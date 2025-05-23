<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\MembershipType;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Entity\User;
use App\Enums\SaleItemType;
use App\Repository\MembershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MembershipController extends AbstractController
{
    #[Route('/memberships', name: 'memberships_index', methods: ['GET'], format: 'json')]
    public function index(MembershipRepository $memberships): Response
    {
        return $this->json(['data' => $memberships->findAll()]);
    }

    #[Route('/memberships/{id}', name: 'memberships_show', methods: ['GET'], format: 'json')]
    public function show(Membership $membership): Response
    {
        return $this->json(data: $membership, context: ['groups' => ['membership:details', 'user:list']]);
    }

    #[Route('/memberships', name: 'memberships_create', methods: ['POST'], format: 'JSON')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $payload = $request->getPayload();

        /** @var User $creator */
        $creator = $this->getUser();

        /** @var User[] $users */
        $users = $entityManager->createQuery('
            SELECT user FROM App\Entity\User user
            WHERE user.id IN (:ids)
        ')
        ->setParameter('ids', $payload->all('users'))
        ->getResult();

        if (count($users) <= 0) {
            return $this->json(data: ['error' => 'No users'], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var ?MembershipType $membershipType */
        $membershipType = $entityManager->getRepository(MembershipType::class)->find($payload->getInt('type_id'));

        if (null === $membershipType) {
            return $this->json(data: ['error' => 'Membership Type not found'], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (count($users) > $membershipType->getMaxSecondaries() + 1) {
            return $this->json(data: ['error' => 'Invalid number of secondaries', 'a' => $membershipType->getMaxSecondaries(), 'b' => count($users)], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $sale = new Sale(
            creator: $creator,
            customer: $users[0],
        );

        $item = new SaleItem(
            price: $membershipType->getPrice(),
            quantity: 1,
            meta: ['membershipTypeId' => $membershipType->getId(), 'userId' => $users[0]->getId(), 'isPrimary' => true],
            type: SaleItemType::Membership
        );

        $entityManager->persist($item);

        $sale->addItem($item);

        foreach ($users as $user) {
            if ($users[0]->getId() === $user->getId()) {
                continue;
            }

            $secondaryItem = new SaleItem(
                price: $membershipType->getSecondaryPrice(),
                quantity: 1,
                meta: ['membershipTypeId' => $membershipType->getId(), 'userId' => $user->getId(), 'isPrimary' => false],
                type: SaleItemType::Membership
            );

            $entityManager->persist($secondaryItem);

            $sale->addItem($secondaryItem);
        }

        /** @var ?PaymentMethod $paymentMethod */
        $paymentMethod = $entityManager->getRepository(PaymentMethod::class)->find($payload->all('payment')['methodId']);

        if (null === $paymentMethod) {
            return $this->json(data: ['error' => 'Payment method not found'], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $payment = new Payment(
            tendered: (int) $payload->all('payment')['tendered'],
            method: $paymentMethod,
            cashier: $creator
        );

        $entityManager->persist($payment);

        $sale->addPayment($payment);

        if (0 !== $sale->getBalance()) {
            return $this->json(['error' => 'balance is not zero', 'balance' => $sale], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($sale);

        $duration = $membershipType->getDuration();

        $membership = new Membership(
            starting: new \DateTimeImmutable($payload->getString('starting')),
            ending: (new \DateTimeImmutable($payload->getString('starting')))->modify("+ $duration days"),
            type: $membershipType,
            users: $users
        );

        foreach ($users as $user) {
            $user->setMembership($membership);
            $entityManager->persist($user);
        }

        $entityManager->persist($membership);

        $entityManager->flush();

        return $this->json(['data' => $membership->getId()]);
    }
}

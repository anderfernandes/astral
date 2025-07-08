<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Entity\User;
use App\Enums\MemberPosition;
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

        /** @var MembershipRepository $memberships */
        $memberships = $entityManager->getRepository(Membership::class);

        try {
            $membership = $memberships->create(
                primary: $payload->getInt('primary'),
                secondaries: $payload->all('secondaries'),
                typeId: $payload->getInt('typeId'),
                starting: $payload->getInt('starting'),
                creator: $creator
            );
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (null === $membership->getPrimary()) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // CREATE SALE AND SALE ITEMS BASED ON PRIMARY AND SECONDARIES (FREE AND PAID)

        $sale = new Sale(
            creator: $creator,
            customer: $membership->getPrimary()->getUser(),
        );

        $item = new SaleItem(
            price: $membership->getType()->getPrice(),
            quantity: 1,
            meta: ['membershipTypeId' => $membership->getType()->getId(), 'userId' => $membership->getPrimary()->getId(), 'position' => MemberPosition::PRIMARY],
            type: SaleItemType::Membership
        );

        $entityManager->persist($item);

        $sale->addItem($item);

        foreach ($membership->getSecondaries() as $member) {
            if (MemberPosition::PRIMARY === $member->getPosition()) {
                continue;
            }

            $freeSecondaryItem = new SaleItem(
                price: MemberPosition::PAID_SECONDARY === $member->getPosition() ? $membership->getType()->getSecondaryPrice() : 0,
                quantity: 1,
                meta: [
                    'membershipTypeId' => $membership->getType()->getId(),
                    'userId' => $member->getUser()->getId(),
                    'position' => $member->getPosition(),
                ],
                type: SaleItemType::Membership
            );

            $entityManager->persist($freeSecondaryItem);

            $sale->addItem($freeSecondaryItem);
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

        $entityManager->persist($membership);

        $entityManager->flush();

        return $this->json(['data' => $membership->getId()]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Sale;
use App\Entity\User;
use App\Model\MembershipDto;
use App\Repository\MembershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
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

    #[Route('/memberships', name: 'memberships_create', methods: ['POST'], format: 'json')]
    public function create(
        #[MapRequestPayload] MembershipDto $membershipDto,
        EntityManagerInterface $entityManager): Response
    {
        /** @var User $creator */
        $creator = $this->getUser();

        /** @var MembershipRepository $memberships */
        $memberships = $entityManager->getRepository(Membership::class);

        /** @var \App\Repository\SaleRepository $sales */
        $sales = $entityManager->getRepository(Sale::class);

        try {
            $membership = $memberships->create($membershipDto, $creator);

            $sales->createFromMembership(
                membership: $membership,
                payments: $membershipDto->payments,
                creator: $creator
            );
        } catch (\Exception $e) {
            return $this->json(data: ['message' => $e->getMessage(), 'stack' => $e->getTrace()], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json(['data' => $membership->getId()]);
    }

    #[Route('/memberships/{id}', name: 'membership_update', methods: ['PUT'], format: 'json')]
    public function update(
        Membership $membership,
        #[MapRequestPayload] MembershipDto $membershipDto,
        EntityManagerInterface $entityManager,
    ): Response {
        /** @var MembershipRepository $memberships */
        $memberships = $entityManager->getRepository(Membership::class);

        /** @var \App\Repository\SaleRepository $sales */
        $sales = $entityManager->getRepository(Sale::class);

        /** @var User $creator */
        $creator = $this->getUser();

        try {
            $membership = $memberships->update($membership, $membershipDto);

            $sales->createFromMembership(
                membership: $membership,
                payments: $membershipDto->payments,
                creator: $creator
            );
        } catch (\Exception $e) {
            return $this->json(data: ['message' => $e->getMessage(), 'stack' => $e->getTrace()], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json(data: ['data' => $membership->getId()]);
    }
}

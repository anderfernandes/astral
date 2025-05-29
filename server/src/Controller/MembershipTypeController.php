<?php

namespace App\Controller;

use App\Entity\MembershipType;
use App\Repository\MembershipTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MembershipTypeController extends AbstractController
{
    #[Route('/membership-types', name: 'membership-types_index', methods: ['GET'], format: 'json')]
    public function index(MembershipTypeRepository $membershipTypes): Response
    {
        return $this->json(data: ['data' => $membershipTypes->findAll()], context: ['groups' => ['membership:details']]);
    }

    #[Route('/membership-types', name: 'membership-types_create', methods: ['POST'], format: 'json')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $payload = $request->getPayload();

        /**
         * @var \App\Entity\User $user
         */
        $user = $this->getUser();

        $membershipType = new MembershipType(
            name: $payload->getString('name'),
            description: $payload->getString('description'),
            duration: $payload->getInt('duration'),
            price: $payload->getInt('price') * 100,
            paid_secondaries: $payload->getInt('paid_secondaries'),
            secondary_price: $payload->getInt('secondary_price') * 100,
            free_secondaries: $payload->getInt('free_secondaries'),
            is_public: $payload->has('is_public') && $payload->getBoolean('is_public'),
            creator: $user
        );

        $entityManager->persist($membershipType);

        $entityManager->flush();

        return $this->json(data: ['data' => $membershipType->getId()], status: Response::HTTP_CREATED);
    }

    #[Route('/membership-types/{id}', name: 'membership-types_show', methods: ['GET'], format: 'json')]
    public function show(MembershipType $membershipType): Response
    {
        return $this->json(data: $membershipType, context: ['groups' => ['membership:details']]);
    }

    #[Route('/membership-types/{id}', name: 'membership-types_update', methods: ['PUT'], format: 'json')]
    public function update(
        MembershipType $membershipType,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $payload = $request->getPayload();

        $membershipType
            ->setName($payload->getString('name'))
            ->setDescription($payload->getString('description'))
            ->setDuration($payload->getInt('duration'))
            ->setPrice($payload->getInt('price') * 100)
            ->setPaidSecondaries($payload->getInt('paid_secondaries'))
            ->setSecondaryPrice($payload->getInt('secondary_price') * 100)
            ->setFreeSecondaries($payload->getInt('free_secondaries'))
            ->setIsActive($payload->has('is_active') && $payload->getBoolean('is_active'))
            ->setIsPublic($payload->has('is_public') && $payload->getBoolean('is_public'));

        $entityManager->persist($membershipType);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}

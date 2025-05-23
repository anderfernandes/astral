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
        return $this->json(['data' => $membershipTypes->findAll()]);
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
            price: $payload->getInt('price'),
            max_secondaries: $payload->getInt('max_secondaries'),
            secondary_price: $payload->getInt('secondary_price'),
            creator: $user
        );

        $entityManager->persist($membershipType);

        $entityManager->flush();

        return $this->json(['data' => $membershipType->getId()], Response::HTTP_CREATED);
    }

    #[Route('/membership-types/{id}', name: 'membership-types_show', methods: ['GET'], format: 'json')]
    public function show(MembershipType $membershipType): Response
    {
        return $this->json($membershipType);
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
            ->setPrice($payload->getInt('price'))
            ->setMaxSecondaries($payload->getInt('max_secondaries'))
            ->setSecondaryPrice($payload->getInt('secondary_price'));

        $entityManager->persist($membershipType);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}

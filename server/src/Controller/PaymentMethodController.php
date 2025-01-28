<?php

namespace App\Controller;

use App\Entity\PaymentMethod;
use App\Entity\User;
use App\Enums\PaymentMethodType;
use App\Repository\PaymentMethodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentMethodController extends AbstractController
{
    #[Route('/payment-methods', name: 'payment-methods_index', methods: ['GET'], format: 'json')]
    public function index(PaymentMethodRepository $methods): Response
    {
        return $this->json(['data' => $methods->findAll()]);
    }

    #[Route('/payment-methods', name: 'payment-methods_create', methods: ['POST'], format: 'json')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $payload = $request->getPayload();

        /**
         * @var User $user
         */
        $user = $this->getUser();

        $method = new PaymentMethod(
            name: $payload->getString('name'),
            description: $payload->getString('description'),
            type: PaymentMethodType::from($payload->getString('type')),
            creator: $user
        );

        $entityManager->persist($method);

        $entityManager->flush();

        return $this->json(['data' => $method->getId()], Response::HTTP_CREATED);
    }

    #[Route('/payment-methods/{id}', name: 'payment-methods_show', methods: ['GET'], format: 'json')]
    public function show(PaymentMethod $method): Response
    {
        return $this->json($method);
    }

    public function update(
        PaymentMethod $method,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $payload = $request->getPayload();

        $method
            ->setName($payload->getString('name'))
            ->setDescription($payload->getString('description'))
            ->setType(PaymentMethodType::from($payload->getString('type')))
            ->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($method);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
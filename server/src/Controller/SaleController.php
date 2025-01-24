<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Enums\SaleSource;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaleController extends AbstractController
{
    #[Route('/sales', name: 'sales_index', methods: ['GET'], format: 'json')]
    public function index(SaleRepository $sales): Response
    {
        return $this->json(['data' => $sales->findAll()]);
    }

    #[Route('/sales', name: 'sales_create', methods: ['POST'], format: 'json')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): Response
    {
        $sale = new Sale(creator: $this->getUser());

        foreach ($request->getPayload()->all("items") as $item) {
            $item = new SaleItem(
                name: $item['name'],
                description: $item['description'],
                price: $item['price'],
                quantity: $item['quantity'],
                cover: $item['cover'],
                meta: $item['meta'],
             );

            $entityManager->persist($item);
            $sale->addItem($item);
        }

        $entityManager->persist($sale);

        $entityManager->flush();

        return $this->json(['data' => $sale->getId()], 201);
    }

    #[Route('/sales/{id}', name: 'sales_show', methods: ['GET'], format: 'JSON')]
    public function show(Sale $sale): Response
    {
        return $this->json($sale);
    }
}
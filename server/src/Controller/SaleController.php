<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Enums\SaleSource;
use App\Enums\SaleStatus;
use App\Repository\PaymentMethodRepository;
use App\Repository\SaleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
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
        ValidatorInterface $validator,
        PaymentMethodRepository $paymentMethods,
        UserRepository $users
    ): Response
    {
        $payload = $request->getPayload();

        $sale = new Sale(creator: $this->getUser());

        if ($payload->has("customerId")) {

            $customer = $users->find($payload->getInt("customerId"));

            if ($customer !== null) $sale->setCustomer($customer);
        }

        foreach ($payload->all("items") as $item) {

            if ($item['quantity'] === 0)
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            $item = new SaleItem(
                name: $item['name'],
                description: $item['description'],
                price: $item['price'],
                quantity: $item['quantity'],
                cover: $item['cover'],
                meta: $item['meta'],
             );

            $sale->addItem($item);
        }

        if ($sale->getSource() !== SaleSource::Admin) {

            if (!$payload->has("payment")) return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            $method = $paymentMethods->find($payload->all("payment")["methodId"]);

            if ($method === null) return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            $payment = new Payment(
                tendered: (int)$payload->all("payment")["tendered"],
                method: $method
            );

            if ($sale->getCustomer() !== null) $payment->setCustomer($sale->getCustomer());

            $sale->addPayment($payment);

            if ($sale->getBalance() > 0) return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            $entityManager->persist($payment);
        }

        foreach ($sale->getItems() as $item) {
            $entityManager->persist($item);
        }

        if ($sale->getBalance() <= 0)
            $sale->setStatus(SaleStatus::Completed);

        $entityManager->persist($sale);

        $entityManager->flush();

        return $this->json(['data' => $sale->getId()], 201);
    }

    #[Route('/sales/{id}', name: 'sales_show', methods: ['GET'], format: 'json')]
    public function show(Sale $sale): Response
    {
        return $this->json($sale);
    }

    #[Route('/sales/{id}', name: 'sales_update', methods: ['PUT'], format: 'json')]
    public function update(
        Sale $sale,
        Request $request,
        EntityManagerInterface $entityManager,
        PaymentMethodRepository $paymentMethods,
    ): Response
    {
        $payload = $request->getPayload();

        if ($request->query->has('refund')) {

            if ($sale->getPayments()->count() > 1 && $sale->getStatus() === SaleStatus::Completed)
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            $payment = new Payment(
                tendered: $sale->getTotal() * -1,
                method: $sale->getPayments()->last()->getMethod(),
                cashier: $this->getUser(),
                customer: $sale->getCustomer()
            );

            $sale->addPayment($payment);

            $entityManager->persist($payment);
        }

        $entityManager->persist($sale);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}
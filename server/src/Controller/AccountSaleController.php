<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Enums\PaymentMethodType;
use App\Enums\SaleSource;
use App\Enums\SaleStatus;
use App\Repository\PaymentMethodRepository;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountSaleController extends AbstractController
{
    #[Route('/account/sales', name: 'account-sales_index', methods: ['GET'], format: 'json')]
    public function index(SaleRepository $sales)
    {
        /* @var \App\Entity\User $customer */
        $customer = $this->getUser();

        return $this->json(['data' => $sales->findBy(['customer_id' => $customer->getId()])]);
    }

    #[Route('/account/sales/{session}', name: 'account-sales_show', methods: ['GET'], format: 'json')]
    public function show(string $session, SaleRepository $sales, PaymentMethodRepository $paymentMethods, EntityManagerInterface $entityManager): Response
    {
        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

        $sale = $sales->findOneBy(['session' => $session]);

        if ($sale === null) {
            return new Response(status: Response::HTTP_NOT_FOUND);
        }

        if ($sale->getStatus() === SaleStatus::OPEN && $sale->getSource() === SaleSource::INTERNAL) {
            /* @var \Stripe\Checkout\Session $session */
            $session = $stripe->checkout->sessions->retrieve($session);

            $method = $paymentMethods->findOneBy(['type' => PaymentMethodType::ONLINE->value]);

            if ($method === null)
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            $payment = new Payment(
                tendered: $session->amount_total,
                method: $method,
             );

            $sale->addPayment($payment);

            $entityManager->persist($payment);

            if ($sale->getBalance() !== 0)
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            $sale->setStatus(SaleStatus::COMPLETED);

            $entityManager->persist($sale);
        }

        return $this->json($sale);
    }
}
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
    public function index(SaleRepository $sales): Response
    {
        /** @var \App\Entity\User $customer **/
        $customer = $this->getUser();

        return $this->json(['data' => $sales->findBy(['customer' => $customer])]);
    }

    #[Route('/account/sales/{id}', name: 'account-sales_show', methods: ['GET'], format: 'json')]
    public function show(Sale $sale): Response
    {
        return $this->json($sale);
    }

    #[Route('/account/sales/{session}', name: 'account-sales_update', methods: ['PUT'], format: 'json')]
    public function update(
        string $session,
        SaleRepository $sales,
        PaymentMethodRepository $paymentMethods,
        EntityManagerInterface $entityManager
    ): Response
    {
        $sale = $sales->findOneBy(['session' => $session]);

        if ($sale === null) {
            //return new Response(status: Response::HTTP_NOT_FOUND);
            return $this->json(['error' => 'Sale not found'], status: RESPONSE:: HTTP_NOT_FOUND);
        }

        if ($sale->getStatus() === SaleStatus::OPEN && $sale->getSource() === SaleSource::INTERNAL) {

            try {
                $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

                /* @var \Stripe\Checkout\Session $session */
                $session = $stripe->checkout->sessions->retrieve($session);

            } catch (\Stripe\Exception\ApiErrorException $e) {
                //return new Response(status: Response::HTTP_NOT_FOUND);
                return $this->json(['error' => 'Session not found'], status: RESPONSE:: HTTP_NOT_FOUND);
            }

            $method = $paymentMethods->findOneBy(['type' => PaymentMethodType::ONLINE->value]);

            if ($method === null) {
                //return new Response(status: Response::HTTP_NOT_FOUND);
                return $this->json(['error' => "Payment method not found"], status: RESPONSE:: HTTP_NOT_FOUND);
            }

            $payment = new Payment(
                tendered: $session->amount_total,
                method: $method,
             );

            $sale->addPayment($payment);

            $entityManager->persist($payment);

            if ($sale->getBalance() !== 0)
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            // TODO: CREATE TICKETS

            $sale->setStatus(SaleStatus::COMPLETED);

            $entityManager->persist($sale);

            $entityManager->flush();
        }

        return $this->json(['data' => $sale->getId()]);
    }
}
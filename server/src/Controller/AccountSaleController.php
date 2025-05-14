<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Enums\PaymentMethodType;
use App\Enums\SaleItemType;
use App\Enums\SaleSource;
use App\Enums\SaleStatus;
use App\Repository\PaymentMethodRepository;
use App\Repository\SaleRepository;
use App\Service\Cart;
use App\Service\TicketService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AccountSaleController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/account/sales', name: 'account-sales_index', methods: ['GET'], format: 'json')]
    public function index(SaleRepository $sales): Response
    {
        /** @var \App\Entity\User $customer * */
        $customer = $this->getUser();

        $sales = $sales->findBy(['customer' => $customer]);

        return $this->json(['data' => $sales]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/account/sales/{id}', name: 'account-sales_show', methods: ['GET'], format: 'json')]
    public function show(Sale $sale, EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager->createQuery('
            SELECT event FROM App\Entity\Event event
            WHERE event.id in (:ids)
        ')->setParameter('ids', $sale->getEventIds())->getResult();

        $sale->setEvents($events);

        return $this->json($sale);
    }

    #[Route('/account/sales/{session}', name: 'account-sales_update', methods: ['POST'], format: 'json')]
    public function update(
        string $session,
        SaleRepository $sales,
        PaymentMethodRepository $paymentMethods,
        EntityManagerInterface $entityManager,
        Cart $cart,
        TicketService $ticketService,
    ): Response {
        if (0 === count($cart->getItems())) {
            return $this->json(['error' => 'Cart is empty']);
        }
        // $sale = $sales->findOneBy(['session' => $session]);

        // if (null === $sale) {
        //     // return new Response(status: Response::HTTP_NOT_FOUND);
        //     return $this->json(['error' => 'Sale not found'], status: Response::HTTP_NOT_FOUND);
        // }

        try {
            $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

            /* @var \Stripe\Checkout\Session $session */
            $session = $stripe->checkout->sessions->retrieve($session);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // return new Response(status: Response::HTTP_NOT_FOUND);
            return $this->json(['error' => 'Session not found'], status: Response::HTTP_NOT_FOUND);
        }

        $method = $paymentMethods->findOneBy(['type' => PaymentMethodType::ONLINE->value]);

        if (null === $method) {
            // return new Response(status: Response::HTTP_NOT_FOUND);
            return $this->json(['error' => 'Payment method not found'], status: Response::HTTP_NOT_FOUND);
        }

        /** @var \App\Entity\User $customer * */
        $customer = $this->getUser();

        $sale = new Sale();
        $sale->setCustomer($customer);
        // TODO: MAKE SURE SESSION DOES NOT EXIST
        $sale->setSession($session->id);
        $sale->setSource(SaleSource::INTERNAL);

        foreach ($cart->getCartItemsWithData() as $item) {
            $item = new SaleItem(
                name: $item['name'],
                description: $item['description'],
                price: $item['price'],
                quantity: $item['quantity'],
                cover: $item['cover'],
                meta: [
                    'eventId' => (int) $item['meta']['eventId'],
                    'ticketTypeId' => (int) $item['meta']['ticketTypeId'],
                ],
            );

            $sale->addItem($item);

            $entityManager->persist($item);
        }

        if (SaleSource::INTERNAL === $sale->getSource()) {
            $convenienceFee = (int) $_ENV['CONVENIENCE_FEE'];

            if ($convenienceFee > 0) {
                $convenienceFeeItem = new SaleItem(
                    name: 'Convenience Fee',
                    description: 'Convenience Fee',
                    price : $convenienceFee,
                    quantity: 1,
                    type: SaleItemType::ConvenienceFee,
                );

                $sale->addItem($convenienceFeeItem);

                $entityManager->persist($convenienceFeeItem);
            }
        }

        $payment = new Payment(
            tendered: $session->amount_total,
            method: $method,
            customer: $customer
        );

        $sale->addPayment($payment);

        if (0 !== $sale->getBalance()) {
            // return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            return $this->json(['sale' => $sale->getItems()], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $sale->setStatus(SaleStatus::COMPLETED);

        $ticketService->create($sale);

        $entityManager->persist($payment);

        $entityManager->persist($sale);

        $entityManager->flush();

        $cart->clear();

        return $this->json(['data' => $sale->getId()]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Enums\SaleSource;
use App\Enums\SaleStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StripeController extends AbstractController
{
    #[Route('/stripe/checkout', name: 'stripe_checkout', methods: ['POST'], format: 'json')]
    public function checkout(Request $request, EntityManagerInterface $entityManager): Response
    {
        $payload = $request->getPayload();

        $saleEventsIds = [];
        $saleTicketTypesIds = [];

        foreach ($payload->all('items') as $item) {
            $saleEventsIds[] = $item['meta']['eventId'];
            $saleTicketTypesIds[] = $item['meta']['ticketTypeId'];
        }

        $saleEventsIds = array_unique($saleEventsIds);
        $saleTicketTypesIds = array_unique($saleTicketTypesIds);

        /** @var \App\Entity\Event[] $events * */
        $events = $entityManager->createQuery(
            'SELECT e FROM App\Entity\Event e
                WHERE e.id IN (:saleEventsIds)
                ORDER BY e.id ASC'
        )->setParameter('saleEventsIds', $saleEventsIds)->getResult();

        /** @var \App\Entity\TicketType[] $ticketTypes * */
        $ticketTypes = $entityManager->createQuery(
            'SELECT tt FROM App\Entity\TicketType tt
                WHERE tt.id IN (:saleTicketTypesIds)
                ORDER BY tt.id ASC'
        )->setParameter('saleTicketTypesIds', $saleTicketTypesIds)->getResult();

        foreach ($events as $event) {
            $saleSeats = 0;

            foreach ($payload->all('items') as $item) {
                if ((int) $item['meta']['eventId'] === $event->getId()) {
                    $saleSeats += (int) $item['quantity'];
                }
            }

            if ($saleSeats > $event->getSeats()['available']) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

        $line_items = [];

        $sale = new Sale();

        foreach ($payload->all('items') as $item) {
            if ('ticket' === $item['type']) {
                if (0 === $item['quantity']) {
                    return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $meta = $item['meta'];

                /** @var ?\App\Entity\Event $event * */
                $event = null;

                foreach ($events as $e) {
                    if ($e->getId() === (int) $meta['eventId']) {
                        $event = $e;
                        break;
                    }
                }

                if (null === $event) {
                    return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                /** @var ?\App\Entity\TicketType $ticketType * */
                $ticketType = null;

                foreach ($ticketTypes as $tt) {
                    if ($tt->getId() === (int) $meta['ticketTypeId']) {
                        $ticketType = $tt;
                        break;
                    }
                }

                if (null === $ticketType) {
                    return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $line_items[] = [
                    'quantity' => $item['quantity'],
                    'price_data' => [
                        'currency' => 'USD',
                        'unit_amount' => $ticketType->getPrice(),
                        'product_data' => [
                            'name' => $ticketType->getName().' '.$item['type'],
                            'description' => $item['description'],
                            'images' => [$_ENV['FRONTEND_URL'].$item['cover']],
                        ],
                    ],
                ];

                $item = new SaleItem(
                    name: $item['name'],
                    description: $item['description'],
                    price: $ticketType->getPrice(),
                    quantity: $item['quantity'],
                    cover: $item['cover'],
                    meta: [
                        'eventId' => (int) $meta['eventId'],
                        'ticketTypeId' => (int) $meta['eventId'],
                    ],
                );

                $sale->addItem($item);

                $entityManager->persist($item);
            }
        }

        try {
            $taxRate = $stripe->taxRates->retrieve($_ENV['STRIPE_TAX_RATE_ID']);

            if (null == $taxRate) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            for ($i = 0; $i < count($line_items); ++$i) {
                $line_items[$i]['tax_rates'] = [$taxRate->id];
            }

            $checkout = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => $_ENV['FRONTEND_URL'].'/account/orders/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $_ENV['FRONTEND_URL'].'/cart?canceled',
                'line_items' => $line_items,
            ]);

            /** @var \App\Entity\User $customer * */
            $customer = $this->getUser();

            $sale->setCustomer($customer);
            $sale->setSession($checkout->id);
            $sale->setStatus(SaleStatus::OPEN);
            $sale->setSource(SaleSource::INTERNAL);

            $entityManager->persist($sale);

            $entityManager->flush();

            return $this->json(['data' => $checkout->url, 'id' => $checkout->id]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

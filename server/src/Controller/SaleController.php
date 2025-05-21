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
use App\Repository\UserRepository;
use App\Service\TicketService;
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
        $sales = $sales->createQueryBuilder('s')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->execute();

        return $this->json(
            data: ['data' => $sales],
            context: ['groups' => ['sale:list', 'user:list', 'ticket:list', 'ticket-type:list']]
        );
    }

    #[Route('/sales', name: 'sales_create', methods: ['POST'], format: 'json')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        PaymentMethodRepository $paymentMethods,
        UserRepository $users,
        TicketService $ticketService,
    ): Response {
        $payload = $request->getPayload();

        /** @var \App\Entity\User $cashier * */
        $cashier = $this->getUser();

        $sale = new Sale(creator: $cashier);

        $saleEventsIds = [];
        $saleTicketTypesIds = [];

        foreach ($payload->all('items') as $item) {
            $saleEventsIds[] = $item['meta']['eventId'];
            $saleTicketTypesIds[] = $item['meta']['ticketTypeId'];
        }

        $saleEventsIds = array_unique($saleEventsIds);
        $saleTicketTypesIds = array_unique($saleTicketTypesIds);

        /** @var \App\Entity\Event[] $events */
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

        if ($payload->has('customerId')) {
            $customer = $users->find($payload->getInt('customerId'));

            if (null !== $customer) {
                $sale->setCustomer($customer);
            }
        }

        foreach ($payload->all('items') as $item) {
            if ($item['type'] === SaleItemType::Ticket->value) {
                /** @var ?\App\Entity\Event $event */
                $event = null;

                foreach ($events as $e) {
                    if ($e->getId() === (int) $item['meta']['eventId']) {
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
                    if ($tt->getId() === (int) $item['meta']['ticketTypeId']) {
                        $ticketType = $tt;
                        break;
                    }
                }

                if (null === $ticketType) {
                    return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $item = new SaleItem(
                    price: $ticketType->getPrice(),
                    quantity: $item['quantity'],
                    meta: [
                        'eventId' => (int) $item['meta']['eventId'],
                        'ticketTypeId' => (int) $item['meta']['ticketTypeId'],
                    ],
                );

                $sale->addItem($item);

                $entityManager->persist($item);
            }
        }

        foreach ($events as $event) {
            $saleSeats = 0;

            foreach ($sale->getItems() as $item) {
                if ($item->getMeta()['eventId'] === $event->getId()) {
                    $saleSeats += $item->getQuantity();
                }
            }

            if ($saleSeats > $event->getSeats()['available']) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $sale->addEvent($event);
        }

        if (SaleSource::CASHIER === $sale->getSource()) {
            if (!$payload->has('payment')) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $method = $paymentMethods->find($payload->all('payment')['methodId']);

            if (null === $method) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $payment = new Payment(
                tendered: (int) $payload->all('payment')['tendered'],
                method: $method,
                cashier: $cashier
            );

            if (PaymentMethodType::CASH !== $method->getType()) {
                if (!$payload->has('reference')) {
                    return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $reference = $payload->getString('reference');

                if (strlen($reference) <= 0) {
                    return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $payment->setReference($payload->getString('reference'));
                $payment->setTendered($sale->getTotal());
            }

            if (null !== $sale->getCustomer()) {
                $payment->setCustomer($sale->getCustomer());
            }

            $sale->addPayment($payment);

            if (0 !== $sale->getBalance()) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $sale->setStatus(SaleStatus::COMPLETED);
            $ticketService->create($sale);

            $entityManager->persist($payment);
        }

        $entityManager->persist($sale);

        $entityManager->flush();

        return $this->json(['data' => $sale->getId()], 201);
    }

    #[Route('/sales/{id}', name: 'sales_show', methods: ['GET'], format: 'json')]
    public function show(Sale $sale, EntityManagerInterface $entityManager): Response
    {
        return $this->json(
            data: $sale,
            context: ['groups' => ['sale:details', 'user:list', 'payment:list', 'memo:list', 'ticket:list', 'event:list', 'show:list']]
        );
    }

    #[Route('/sales/{id}/tickets', name: 'sale_tickets_show', methods: ['GET'], format: 'json')]
    public function tickets(Sale $sale): Response
    {
        return $this->json(
            data: ['data' => $sale->getTickets()],
            context: ['groups' => ['ticket:details', 'event:details', 'user:list', 'show:details']]
        );
    }

    #[Route('/sales/{id}', name: 'sales_update', methods: ['PUT'], format: 'json')]
    public function update(
        Sale $sale,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($request->query->has('refund')) {
            if ($sale->getPayments()->count() > 1 && SaleStatus::COMPLETED === $sale->getStatus()) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $payment = new Payment(
                tendered: $sale->getTotal() * -1,
                method: $sale->getPayments()->last()->getMethod(),
                cashier: $user,
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

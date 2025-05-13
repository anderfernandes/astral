<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Sale;
use App\Entity\Ticket;
use App\Entity\TicketType;
use App\Enums\SaleItemType;
use Doctrine\ORM\EntityManagerInterface;

class TicketService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * Creates ticket for a sale.
     */
    public function create(Sale $sale): void
    {
        /** @var Event[] $events * */
        $events = $this->entityManager->createQuery('
            SELECT event FROM App\Entity\Event event
            WHERE event.id in (:ids)
        ')->setParameter('ids', $sale->getEventIds())->getResult();

        /** @var TicketType[] $ticketTypes * */
        $ticketTypes = $this->entityManager->createQuery('
            SELECT ticketType FROM App\Entity\TicketType ticketType
            WHERE ticketType.id in (:ids)
        ')->setParameter('ids', $sale->getTicketTypeIds())->getResult();

        foreach ($sale->getItems() as $item) {
            if (SaleItemType::Ticket !== $item->getType()) {
                continue;
            }

            for ($i = 0; $i < $item->getQuantity(); ++$i) {
                $ticket = new Ticket();

                foreach ($ticketTypes as $ticketType) {
                    if ($ticketType->getId() === $item->getMeta()['ticketTypeId']) {
                        $ticket->setType($ticketType);
                        break;
                    }
                }

                foreach ($events as $event) {
                    if ($event->getId() === $item->getMeta()['eventId']) {
                        $ticket->setEvent($event);
                        break;
                    }
                }

                $ticket->setCustomer($sale->getCustomer());

                $ticket->setCashier($sale->getCreator());

                $sale->addTicket($ticket);

                $this->entityManager->persist($ticket);
            }
        }

        // $this->entityManager->flush();
    }
}

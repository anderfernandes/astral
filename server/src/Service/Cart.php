<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    /** @var CartItem[] */
    private array $items = [];

    /** @var int[] */
    private array $eventIds = [];

    /** @var int[] */
    private array $ticketTypeIds = [];

    public function __construct(private RequestStack $requestStack, private EntityManagerInterface $entityManager)
    {
        if (!$requestStack->getSession()->has('cart')) {
            $requestStack->getSession()->set('cart', []);
        }

        $items = $this->requestStack->getSession()->get('cart', []);

        foreach ($items as $item) {
            $this->items[] = new CartItem(
                quantity: $item['quantity'],
                meta: $item['meta']
            );

            $this->eventIds[] = $item['meta']['eventId'];
            $this->ticketTypeIds[] = $item['meta']['ticketTypeId'];
        }
    }

    /**
     * @return list<array{quantity: int, meta: array{eventId: int, ticketTypeId: int}}>
     */
    public function getItems(): array
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = [
                'quantity' => $item->getQuantity(),
                'meta' => [
                    'eventId' => $item->getMeta()->getEventId(),
                    'ticketTypeId' => $item->getMeta()->getTicketTypeId(),
                ],
            ];
        }

        return $items;
    }

    /**
     * @param array{eventId: int, ticketTypeId: int} $meta
     */
    private function findIndex(array $meta): int
    {
        $meta = new CartMeta($meta);

        for ($i = 0; $i < count($this->items); ++$i) {
            if ($this->items[$i]->getMeta() == $meta) {
                return $i;
            }
        }

        return -1;
    }

    /**
     * @param array{eventId: int, ticketTypeId: int} $meta
     */
    public function add(array $meta, ?int $quantity = 1): void
    {
        $index = $this->findIndex($meta);

        // If item exists, add quantity to quantity
        if ($index >= 0) {
            $this->items[$index]->setQuantity($this->items[$index]->getQuantity() + $quantity);
        } else {
            // If item does not exists, add with quantity
            $this->items[] = new CartItem($meta);

            $this->eventIds[] = $meta['eventId'];
            $this->ticketTypeIds[] = $meta['ticketTypeId'];
        }

        $this->requestStack->getSession()->set('cart', $this->getItems());
    }

    /**
     * @param array{eventId: int, ticketTypeId: int} $meta
     */
    public function remove(array $meta, ?int $quantity = 1): void
    {
        $index = $this->findIndex($meta);

        if ($index < 0) {
            return;
        }

        $item = $this->items[$index];

        if ($quantity >= $item->getQuantity()) {
            $this->removeAll($meta);

            return;
        }

        $item->setQuantity($item->getQuantity() - $quantity);

        if (0 === $item->getQuantity()) {
            array_splice($this->items, $index, 1);
        }

        $this->requestStack->getSession()->set('cart', $this->getItems());
    }

    /**
     * @param array{eventId: int, ticketTypeId: int} $meta
     */
    public function removeAll(array $meta): void
    {
        $index = $this->findIndex($meta);

        if ($index < 0) {
            return;
        } // item doesn't exists

        array_splice($this->items, $index, 1);

        $this->requestStack->getSession()->set('cart', $this->getItems());
    }

    public function clear(): void
    {
        $this->items = [];

        $this->requestStack->getSession()->remove('cart');
    }

    /**
     * @return int[]
     */
    public function getEventIds(): array
    {
        return array_unique($this->eventIds);
    }

    /**
     * @return int[]
     */
    public function getTicketTypeIds(): array
    {
        return array_unique($this->ticketTypeIds);
    }

    /**
     * @return list<array{quantity: int, name: string, description: string, price: int, cover: string, type: string, meta: array{eventId: int, ticketTypeId: int, eventStarting: \DateTime|null}}>
     */
    public function getCartItemsWithData(): array
    {
        $data = [];

        $events = $this->entityManager->createQuery('
                SELECT e FROM App\Entity\Event e
                WHERE e.id IN (:ids)
            ')->setParameter('ids', $this->getEventIds())->getResult();

        $ticketTypes = $this->entityManager->createQuery('
                SELECT tt from App\Entity\TicketType tt
                WHERE tt.id in (:ids)
            ')->setParameter('ids', $this->getTicketTypeIds())->getResult();

        foreach ($this->items as $item) {
            $meta = $item->getMeta();

            /** @var \App\Entity\Event|null $event */
            $event = null;

            /** @var \App\Entity\TicketType|null $ticketType * */
            $ticketType = null;

            foreach ($events as $e) {
                if ($e->getId() === $meta->getEventId()) {
                    $event = $e;
                    break;
                }
            }

            if (null === $event) {
                throw new \Exception(message: 'Event not found in array of events.');
            }

            foreach ($ticketTypes as $tt) {
                if ($tt->getId() === $meta->getTicketTypeId()) {
                    $ticketType = $tt;
                    break;
                }
            }

            if (null === $ticketType) {
                throw new \Exception(message: 'Ticket type not found in array of ticket types.');
            }

            /** @var \App\Entity\Show $show */
            $show = $event->getShows()->first();

            $data[] = [
                'quantity' => $item->getQuantity(),
                'meta' => [
                    'eventId' => $meta->getEventId(),
                    'ticketTypeId' => $meta->getTicketTypeId(),
                    'eventStarting' => $event->getStarting(),
                ],
                'name' => $ticketType->getName(),
                'description' => $event->getShows()->first()->getName(),
                'price' => $ticketType->getPrice(),
                'cover' => '/default.png' === $show->getCover() ? $show->getCover() : '/uploads'.$show->getCover(),
                'type' => 'ticket',
            ];
        }

        // $this->requestStack->getSession()->set('cart', $this->getItems());

        return $data;
    }
}

class CartItem
{
    private CartMeta $meta;
    private int $quantity = 0;

    /**
     * @param array{eventId: int, ticketTypeId: int} $meta
     */
    public function __construct(array $meta, ?int $quantity = 1)
    {
        $this->meta = new CartMeta($meta);
        $this->quantity = $this->quantity + $quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getMeta(): CartMeta
    {
        return $this->meta;
    }
}

class CartMeta
{
    private int $eventId;
    private int $ticketTypeId;

    /**
     * @param array{eventId: int, ticketTypeId: int} $meta
     */
    public function __construct(array $meta)
    {
        $this->eventId = $meta['eventId'];
        $this->ticketTypeId = $meta['ticketTypeId'];
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function getTicketTypeId(): int
    {
        return $this->ticketTypeId;
    }
}

<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_show', methods: ['GET'], format: 'json')]
    public function show(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $cart = $request->getSession()->get('cart', []);

        if (count($cart) > 0) {
            $cart = new Cart($cart);

            $events = $entityManager->createQuery('
                SELECT e FROM App\Entity\Event e
                WHERE e.id IN (:ids)
            ')->setParameter('ids', $cart->getEventIds())->getResult();

            $ticketTypes = $entityManager->createQuery('
                SELECT tt from App\Entity\TicketType tt
                WHERE tt.id in (:ids)
            ')->setParameter('ids', $cart->getTicketTypeIds())->getResult();

            $cart = $cart->getCartItemsWithData($events, $ticketTypes);
        }

        return $this->json(['data' => $cart]);
    }

    #[Route('/cart', name: 'cart_update', methods: ['POST'], format: 'json')]
    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$request->getSession()->has('cart')) {
            $request->getSession()->set('cart', []);
        }

        $meta = [
            'eventId' => $request->getPayload()->getInt('eventId'),
            'ticketTypeId' => $request->getPayload()->getInt('ticketTypeId'),
        ];

        $cart = new Cart($request->getSession()->get('cart'));

        $action = $request->query->getString('action');

        match ($action) {
            'add' => $cart->add($meta),
            'removeOne' => $cart->remove($meta),
            'removeAll' => $cart->removeAll($meta),
            default => $cart->add($meta),
        };

        $request->getSession()->set('cart', $cart->getItems());

        $events = $entityManager->createQuery('
            SELECT e FROM App\Entity\Event e
            WHERE e.id IN (:ids)
        ')->setParameter('ids', $cart->getEventIds())->getResult();

        $ticketTypes = $entityManager->createQuery('
            SELECT tt from App\Entity\TicketType tt
            WHERE tt.id in (:ids)
        ')->setParameter('ids', $cart->getTicketTypeIds())->getResult();

        return $this->json(['data' => $cart->getCartItemsWithData($events, $ticketTypes)]);
    }

    #[Route('/cart', name: 'cart_clear', methods: ['DELETE'], format: 'json')]
    public function delete(Request $request): Response
    {
        $request->getSession()->remove('cart');

        return new Response(status: Response::HTTP_OK);
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

class Cart
{
    /** @var CartItem[] */
    private array $items = [];

    /** @var int[] */
    private array $eventIds = [];

    /** @var int[] */
    private array $ticketTypeIds = [];

    /**
     * @param list<array{quantity: int, meta: array{eventId: int, ticketTypeId: int}}> $items
     */
    public function __construct(array $items)
    {
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

            return;
        }

        // If item does not exists, add with quantity
        $this->items[] = new CartItem($meta);

        $this->eventIds[] = $meta['eventId'];
        $this->ticketTypeIds[] = $meta['ticketTypeId'];
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
    }

    public function clear(): void
    {
        $this->items = [];
    }

    /*
    * @return int[]
    */
    public function getEventIds(): array
    {
        return array_unique($this->eventIds);
    }

    /*
    * @return int[]
    */
    public function getTicketTypeIds(): array
    {
        return array_unique($this->ticketTypeIds);
    }

    /*
    * @param Event[] $events
    * @param TicketType[] $ticketTypes
    * @return list<array>
    */
    public function getCartItemsWithData(array $events, array $ticketTypes): array
    {
        $data = [];

        foreach ($this->items as $item) {
            $meta = $item->getMeta();

            /** @var Event|null $event */
            $event = null;

            /* @var TicketType $ticketType */
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
                'meta' => ['eventId' => $meta->getEventId(), 'ticketTypeId' => $meta->getTicketTypeId()],
                'name' => $ticketType->getName(),
                'description' => '#'.$event->getId(),
                'price' => $ticketType->getPrice(),
                'cover' => '/default.png' === $show->getCover() ? $show->getCover() : '/uploads/'.$show->getCover(),
                'type' => 'ticket',
            ];
        }

        return $data;
    }
}

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
            foreach ($cart as &$item) {
                /** @var Event * */
                $event = $entityManager->getRepository(Event::class)->find($item['meta']['eventId']);

                if (null == $event) {
                    return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                /** @var TicketType * */
                $ticketType = $entityManager->getRepository(TicketType::class)->find($item['meta']['ticketTypeId']);

                if (null == $ticketType) {
                    return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $item = [
                    ...$item,
                    'name' => $ticketType->getName(),
                    'description' => '#'.$event->getId(),
                    'price' => $ticketType->getPrice(),
                    'cover' => '/uploads/'.$event->getShows()->first()->getCover(),
                    'type' => 'ticket',
                ];
            }
        }

        return $this->json(['data' => $cart]);
    }

    #[Route('/cart', name: 'cart_update', methods: ['POST'], format: 'json')]
    public function update(Request $request): Response
    {
        $meta = [
            'eventId' => $request->getPayload()->getInt('eventId'),
            'ticketTypeId' => $request->getPayload()->getInt('ticketTypeId'),
        ];

        $cart = $request->getSession()->get('cart');

        if (null === $cart) {
            $cart = [];
        }

        $hasItem = false;

        foreach ($cart as &$item) {
            if (
                $item['meta']['ticketTypeId'] == $meta['ticketTypeId']
                && $item['meta']['eventId'] == $meta['eventId']
            ) {
                $item['quantity'] = $item['quantity'] + 1;
                $hasItem = true;
                break;
            }
        }

        // unset($item)

        if (!$hasItem) {
            $cart[] = ['meta' => $meta, 'quantity' => 1];
        }

        // TODO: ENSURE UNIQUE, ENSURE EVENT EXISTS AND HAS SEATS, ENSURE TICKET TYPE EXISTS
        $request->getSession()->set('cart', $cart);

        // return new Response(status: Response::HTTP_OK);
        // return $this->json(["data" => $request->getSession()->get("cart", [])]);
        return $this->json(['data' => $cart]);
    }

    #[Route('/cart', name: 'cart_clear', methods: ['DELETE'], format: 'json')]
    public function delete(Request $request): Response
    {
        $request->getSession()->remove('cart');

        return new Response(status: Response::HTTP_OK);
    }
}

<?php

namespace App\Controller;

use App\Helpers\Cart;
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

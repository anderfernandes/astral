<?php

namespace App\Controller;

use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_show', methods: ['GET'], format: 'json')]
    public function show(Cart $cart): Response
    {
        return $this->json(['data' => $cart->getCartItemsWithData()]);
    }

    #[Route('/cart', name: 'cart_update', methods: ['POST'], format: 'json')]
    public function update(Request $request, Cart $cart): Response
    {
        $meta = [
            'eventId' => $request->getPayload()->getInt('eventId'),
            'ticketTypeId' => $request->getPayload()->getInt('ticketTypeId'),
        ];

        $action = $request->query->getString('action');

        match ($action) {
            'add' => $cart->add($meta),
            'removeOne' => $cart->remove($meta),
            'removeAll' => $cart->removeAll($meta),
            default => $cart->add($meta),
        };

        return $this->json(['data' => $cart->getCartItemsWithData()]);
    }

    #[Route('/cart', name: 'cart_clear', methods: ['DELETE'], format: 'json')]
    public function delete(Cart $cart): Response
    {
        $cart->clear();

        return new Response(status: Response::HTTP_OK);
    }
}

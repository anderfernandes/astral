<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_show', methods: ['GET'])]
    public function show(Request $request): Response
    {
        return $this->json(['data' => $request->getSession()->get('cart')]);
    }

    #[Route('/cart', name: 'cart_update', methods: ['POST'])]
    public function update(Request $request): Response
    {
        // TODO: ENSURE UNIQUE, ENSURE EVENT EXISTS AND HAS SEATS, ENSURE TICKET TYPE EXISTS
        $request->getSession()->set('cart', $request->getPayload());

        return new Response(status: Response::HTTP_OK);
    }
}
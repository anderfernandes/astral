<?php

namespace App\Controller;

use Stripe\Exception\ApiErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StripeController extends AbstractController
{
    #[Route('/stripe/checkout', name: 'stripe_checkout', methods: ['POST'], format: 'json')]
    public function checkout(Request $request): Response
    {
        $payload = $request->getPayload();

        // TODO: CHECK IF THERE ARE SEATS AVAILABLE BEFORE TAKING MONEY!

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

        $line_items = [];

        foreach ($payload->all('items') as $item) {
            $line_items[] = [
                'quantity' => $item['quantity'],
                'price_data' =>  [
                    'currency' => 'USD',
                    'unit_amount' => $item['price'],
                    'product_data' => [
                        'name' => $item['description'] . ' ' . $item['name'],
                        'description' => $item['type'],
                        'images' => ['http://localhost:3000' . $item['cover']]
                    ]
                ]
            ];
        }

        try {
            $checkout = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => "http://localhost:3000/",
                'cancel_url' => "http://localhost:3000/cart",
                'line_items' => $line_items
            ]);
            return $this->json(['data' => $checkout->url]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return $this->json($e->getError(), status: $e->getHttpStatus());
        }
    }
}
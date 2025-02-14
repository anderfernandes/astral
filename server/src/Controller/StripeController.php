<?php

namespace App\Controller;

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
        // TODO: ENSURE ALL STRIPE STUFF IS OK BEFORE DOING ANYTHING WITH STRIPE

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

        $line_items = [];

        foreach ($payload->all('items') as $item) {
            $line_items[] = [
                'quantity' => $item['quantity'],
                'price_data' =>  [
                    'currency' => 'USD',
                    'unit_amount' => $item['price'],
                    'product_data' => [
                        'name' => $item['name'] . ' ' . $item['type'],
                        'description' => $item['description'],
                        'images' => ['http://localhost:3000' . $item['cover']]
                    ]
                ]
            ];
        }

        try {
            $taxRate = $stripe->taxRates->retrieve($_ENV['STRIPE_TAX_RATE_ID']);

            if ($taxRate === null)
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

            for ($i = 0; $i < count($line_items); $i++) {
                $line_items[$i]['tax_rates'] = [$taxRate->id];
            }


            $checkout = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => "http://localhost:3000/",
                'cancel_url' => "http://localhost:3000/cart",
                'line_items' => $line_items
            ]);
            return $this->json(['data' => $checkout->url, 'items' => $line_items]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
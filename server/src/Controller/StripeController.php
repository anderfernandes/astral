<?php

namespace App\Controller;

use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StripeController extends AbstractController
{
    #[Route('/stripe/checkout', name: 'stripe_checkout', methods: ['POST'], format: 'json')]
    public function checkout(Request $request, Cart $cart): Response
    {
        if (count($cart->getItems()) <= 0) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

        $taxRate = $stripe->taxRates->retrieve($_ENV['STRIPE_TAX_RATE_ID']);

        if (null == $taxRate) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $line_items = [];

        foreach ($cart->getCartItemsWithData() as $item) {
            $date = $item['meta']['eventStarting']->setTimezone(new \DateTimeZone('America/Chicago'))->format('D M j o @ g:i A');

            $line_items[] = [
                'tax_rates' => [$taxRate->id],
                'quantity' => $item['quantity'],
                'price_data' => [
                    'tax_behavior' => 'exclusive',
                    'currency' => 'usd',
                    'unit_amount' => $item['price'],
                    'product_data' => [
                        'name' => $item['name'].' '.$item['type'],
                        'description' => '#'.$item['meta']['eventId'].' '.$item['description'].' on '.$date,
                        'images' => [$_ENV['FRONTEND_URL'].$item['cover']],
                    ],
                ],
            ];
        }

        if (isset($_ENV['CONVENIENCE_FEE'])) {
            $line_items[] = [
                'tax_rates' => [$taxRate->id],
                'quantity' => 1,
                'price_data' => [
                    'tax_behavior' => 'exclusive',
                    'currency' => 'usd',
                    'unit_amount' => $_ENV['CONVENIENCE_FEE'],
                    'product_data' => [
                        'name' => 'Convenience Fee',
                        'description' => 'Test Convenience Fee',
                    ],
                ],
            ];
        }

        /** @var \App\Entity\User $customer * */
        $customer = $this->getUser();

        try {
            $session = [
                'customer_email' => $customer->getEmail(),
                'mode' => 'payment',
                'success_url' => $_ENV['FRONTEND_URL'].'/account/orders/{CHECKOUT_SESSION_ID}',
                // 'success_url' => $_ENV['FRONTEND_URL'].'/account/orders/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $_ENV['FRONTEND_URL'].'/cart?canceled',
                'line_items' => $line_items,
            ];

            $checkout = $stripe->checkout->sessions->create($session);

            return $this->json(['data' => $checkout->url, 'id' => $checkout->id]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            return $this->json(data: ['message' => $e->getMessage()], status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

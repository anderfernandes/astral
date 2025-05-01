<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Enums\SaleSource;
use App\Enums\SaleStatus;
use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StripeController extends AbstractController
{
    #[Route('/stripe/checkout', name: 'stripe_checkout', methods: ['POST'], format: 'json')]
    public function checkout(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {
        if (count($cart->getItems()) <= 0) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

        $line_items = [];

        $sale = new Sale();

        foreach ($cart->getCartItemsWithData() as $item) {
            $date = $item['meta']['eventStarting']->setTimezone(new \DateTimeZone('America/Chicago'))->format('D M j o @ g:i A');

            $line_items[] = [
                'quantity' => $item['quantity'],
                'price_data' => [
                    'currency' => 'USD',
                    'unit_amount' => $item['price'],
                    'product_data' => [
                        'name' => $item['name'].' '.$item['type'].' - '.$item['description'],
                        'description' => $date,
                        'images' => [$_ENV['FRONTEND_URL'].$item['cover']],
                    ],
                ],
            ];
        }

        try {
            $taxRate = $stripe->taxRates->retrieve($_ENV['STRIPE_TAX_RATE_ID']);

            if (null == $taxRate) {
                return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            for ($i = 0; $i < count($line_items); ++$i) {
                $line_items[$i]['tax_rates'] = [$taxRate->id];
            }

            $checkout = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => $_ENV['FRONTEND_URL'].'/account/orders/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $_ENV['FRONTEND_URL'].'/cart?canceled',
                'line_items' => $line_items,
            ]);

            /** @var \App\Entity\User $customer * */
            $customer = $this->getUser();

            $sale->setCustomer($customer);
            $sale->setSession($checkout->id);
            $sale->setStatus(SaleStatus::OPEN);
            $sale->setSource(SaleSource::INTERNAL);

            $entityManager->persist($sale);

            $entityManager->flush();

            return $this->json(['data' => $checkout->url, 'id' => $checkout->id]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

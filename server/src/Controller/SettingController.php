<?php

namespace App\Controller;

use App\Repository\PaymentMethodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SettingController extends AbstractController
{
    #[Route('/settings/organization', name: 'settings_organization_show')]
    public function organization(PaymentMethodRepository $paymentMethods): Response
    {
        $hasMethods = count($paymentMethods->findBy(['type' => 'online'])) > 0;

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

        $taxRate = $stripe->taxRates->retrieve($_ENV['STRIPE_TAX_RATE_ID']);

        $convenienceFee = isset($_ENV['CONVENIENCE_FEE']) ? (int) $_ENV['CONVENIENCE_FEE'] : 0;

        $hasStripe = null != $stripe && null != $taxRate;

        return $this->json([
            'name' => $_ENV['NAME'],
            'logo' => $_ENV['LOGO'],
            'cover' => $_ENV['COVER'],
            'address' => $_ENV['ADDRESS'],
            'city' => $_ENV['CITY'],
            'state' => $_ENV['STATE'],
            'zip' => $_ENV['ZIP'],
            'country' => $_ENV['COUNTRY'],
            'phone' => $_ENV['PHONE'],
            'tax' => $_ENV['TAX'] ? $_ENV['TAX'] / 100 : 0,
            'seats' => (int) $_ENV['SEATS'],
            'timezone' => $_ENV['TIMEZONE'],
            'canCheckout' => $hasMethods && $hasStripe,
            'convenienceFee' => $convenienceFee,
        ]);
    }
}

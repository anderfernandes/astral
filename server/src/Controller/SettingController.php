<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingController extends AbstractController
{
    #[Route('/settings/organization', name: 'settings_organization_show')]
    public function organization(): Response
    {
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
            'tax' => (int)$_ENV['TAX'],
            'seats' => (int)$_ENV['SEATS'],
            'timezone' => $_ENV['TIMEZONE']
        ]);
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailController extends AbstractController
{
    #[Route('/emails/activate')]
    public function activate(): Response
    {
        $expires = (new \DateTime('+15 minutes'));
        $token = password_hash('John Doe', PASSWORD_DEFAULT);

        return $this->render('emails/activate.html.twig', [
            'expires' => $expires,
            'name' => 'John Doe',
            'button' => [
                'text' => 'Activate Account',
                'href' => "{$_ENV['FRONTEND_URL']}/activate?token=$token&hash={$expires->getTimestamp()}",
            ],
        ]);
    }

    #[Route('/emails/forgot')]
    public function forgot(): Response
    {
        $expires = new \DateTime('+15 minutes');
        $token = password_hash('John Doe', PASSWORD_DEFAULT);

        return $this->render('emails/forgot.html.twig', [
            'expires' => $expires,
            'name' => 'John Doe',
            'button' => [
                'text' => 'Reset Password',
                'href' => "{$_ENV['FRONTEND_URL']}/reset?token=$token&hash={$expires->getTimestamp()}",
            ],
        ]);
    }
}

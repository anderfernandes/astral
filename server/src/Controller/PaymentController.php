<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Sale;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/payments/{id}', name: 'payments_update', methods: ['PUT'], format: 'json')]
    public function update(
        Payment $payment,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        if (!$request->query->has('refund')) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $sale = $entityManager->getRepository(Sale::class)->find($payment->getSale()->getId());

        if (null === $sale) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $refund = new Payment(
            tendered: $payment->getTendered() * -1,
            method: $payment->getMethod(),
            cashier: $this->getUser(),
            customer: $payment->getCustomer(),
        );

        $sale->addPayment($refund);

        $entityManager->persist($refund);

        $entityManager->flush();

        return new Response(status: Response::HTTP_OK);
    }
}

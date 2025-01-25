<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PaymentMethodRepository;
use App\Repository\PaymentRepository;
use App\Repository\SaleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReportController extends AbstractController
{
    #[Route('reports/{report}', name: 'reports_show', methods: ['GET'], format: 'json')]
    public function show(
        Request $request,
        string $report,
        EntityManagerInterface $entityManager
    ): Response
    {
        if (!in_array($report, ['closeout', 'payment']))
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

        /**
         * @var $users UserRepository
         */
        $users = $entityManager->getRepository(User::class);

        /**
         * @var $cashier User
         */
        $cashier = $users->find($request->query->getInt('cashier'));

        if ($cashier === null)
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

        if (!$request->query->has('start') && !$request->query->has('end'))
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

        $start = (new \DateTimeImmutable())->setTimestamp($request->query->getInt('start'));
        $end = (new \DateTimeImmutable())->setTimestamp($request->query->getInt('end'));

        if ($start > $end)
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);

        $data = match ($report) {
            'closeout' => $this->generateCloseoutReport($cashier, $start, $end, $entityManager),
            'payment' => $this->generatePaymentReport($cashier, $start, $end, $entityManager),
        };

        return $this->json(['data' => $data, 'start' => $start, 'end' => $end]);
    }

    function generateCloseoutReport(
        User $cashier,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        EntityManagerInterface $entityManager
    ): array
    {

        $payments = $entityManager->getConnection()
            ->executeQuery('
                SELECT * FROM payments p
                WHERE p.created_at >= :start AND p.created_at <= :end
                ORDER BY p.id ASC
            ', ['start' => $start->format('Y-m-d H:i:s'), 'end' => $end->format('Y-m-d H:i:s')])
            ->fetchAllAssociative();

        $cashiers = [1];

        $methods = $entityManager->getConnection()
            ->executeQuery('
                SELECT * FROM payment_methods m
                ORDER BY m.id ASC
            ');

        $users = $entityManager->getConnection()
            ->executeQuery('
                SELECT id, first_name, last_name FROM users u
                WHERE u.id IN (:cashiers)
                ORDER BY u.id ASC
            ', ['cashiers' => implode(',', $cashiers)])
            ->fetchAllAssociative();

            return [$users];
    }

    function generatePaymentReport(
        User $cashier,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        EntityManagerInterface $entityManager
    ): array
    {
        return [];
    }
}
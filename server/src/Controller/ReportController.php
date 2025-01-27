<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\ArrayParameterType;
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
        EntityManagerInterface $entityManager,
    ): Response {
        if (!in_array($report, ['closeout', 'payment'])) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /**
         * @var UserRepository $users
         */
        $users = $entityManager->getRepository(User::class);

        /**
         * @var User|null $cashier
         */
        $cashier = $request->query->has('cashier')
            ? $users->find($request->query->getInt('cashier'))
            : null;

        if (!$request->query->has('start') && !$request->query->has('end')) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $start = (new \DateTimeImmutable())->setTimestamp($request->query->getInt('start'));
        $end = (new \DateTimeImmutable())->setTimestamp($request->query->getInt('end'));

        if ($start > $end) {
            return new Response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = match ($report) {
            'closeout' => $this->generateCloseoutReport($cashier, $start, $end, $entityManager),
            'payment' => $this->generatePaymentReport($cashier, $start, $end, $entityManager),
        };

        return $this->json(['data' => $data, 'start' => $start, 'end' => $end]);
    }

    public function generateCloseoutReport(
        ?User $cashier,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        EntityManagerInterface $entityManager,
    ): array {
        $payments = $entityManager->getConnection()
            ->executeQuery('
                SELECT * FROM payments p
                WHERE p.created_at >= :start AND p.created_at <= :end
                ORDER BY p.id ASC
            ', ['start' => $start->format('Y-m-d H:i:s'), 'end' => $end->format('Y-m-d H:i:s')])
            ->fetchAllAssociative();

        $shiftCashiersIds = array_unique(array_column($payments, 'cashier_id'));

        if (null !== $cashier) {
            $shiftCashiersIds = [$cashier->getId()];

            $filteredPayments = [];

            foreach ($payments as $payment) {
                if ($payment['cashier_id'] === $cashier->getId()) {
                    $filteredPayments[] = $payment;
                }
            }

            $payments = $filteredPayments;
        }

        $usedPaymentMethodsIds = array_unique(array_column($payments, 'method_id'));

        $methods = $entityManager->getConnection()
            ->executeQuery('
                SELECT * FROM payment_methods m
                WHERE m.id IN (?)
                ORDER BY m.id ASC
            ', [$usedPaymentMethodsIds], [ArrayParameterType::INTEGER])
            ->fetchAllAssociative();

        $usedPaymentTypes = array_unique(array_column($methods, 'type'));

        $users = $entityManager->getConnection()
            ->executeQuery('
                SELECT id, first_name, last_name FROM users u
                WHERE u.id IN (?)
                ORDER BY u.id DESC
            ', [$shiftCashiersIds], [ArrayParameterType::INTEGER])
            ->fetchAllAssociative();

        $data = [];

        foreach ($shiftCashiersIds as $shiftCashierId) {
            $items = [];
            $transactions = [];

            foreach ($payments as $payment) {
                $methodIndex = array_search($payment['method_id'], array_column($methods, 'id'));

                $t = [
                    ...$payment,
                    'method' => $methods[$methodIndex],
                ];

                if (null === $cashier) {
                    $transactions[] = $t;
                    continue;
                }
                if ($payment['cashier_id'] === $shiftCashierId) {
                    $transactions[] = $t;
                }
            }

            foreach ($usedPaymentTypes as $type) {
                $filteredPayments = [];

                foreach ($transactions as $transaction) {
                    if ($transaction['method']['type'] === $type) {
                        $filteredPayments[] = $transaction;
                    }
                }

                $items[] = [
                    'type' => $type,
                    'transactions' => count($filteredPayments),
                    'amount' => array_sum(array_column($filteredPayments, 'tendered')),
                ];
            }

            $shiftCashierIndex = array_search($shiftCashierId, array_column($users, 'id'));

            $data[] = [
                'cashier' => $users[$shiftCashierIndex],
                'items' => $items,
                'transactions' => $transactions,
                'total' => array_sum(array_column($transactions, 'tendered')),
            ];
        }

        // return $users;

        return [
            'start' => $start,
            'end' => $end,
            'report' => $data,
            'transactions' => count($payments),
            'total' => array_sum(array_column($payments, 'tendered')),
        ];
    }

    public function generatePaymentReport(
        User $cashier,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        EntityManagerInterface $entityManager,
    ): array {
        return [];
    }
}

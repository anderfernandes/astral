<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\User;
use App\Enums\PaymentMethodType;
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

        return $this->json(['data' => $data]);
    }

    public function generateCloseoutReport(
        ?User $cashier,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        EntityManagerInterface $entityManager,
    ): array {
        /** @var Payment[] $payments * */
        $payments = $entityManager->createQuery(
            'SELECT p FROM App\Entity\Payment p
                WHERE p.createdAt >= :start AND p.createdAt <= :end
                ORDER BY p.id ASC'
        )->setParameters([
            'start' => $start->format('Y-m-d H:i:s'),
            'end' => $end->format('Y-m-d H:i:s'),
        ])->getResult();

        /* @var int[] $shiftCashiersIds */
        $shiftCashiersIds = [];

        /* @var int[] $usedPaymentMethodsIds */
        $usedPaymentMethodsIds = [];

        /* @var PaymentMethodType[] $usedPaymentMethodTypes */
        $usedPaymentMethodTypes = [];

        foreach ($payments as $payment) {
            $shiftCashiersIds[] = $payment->getCashier()->getId();
            $usedPaymentMethodsIds[] = $payment->getMethod()->getId();
            $usedPaymentMethodTypes[] = $payment->getMethod()->getType()->value;
        }

        $shiftCashiersIds = array_unique($shiftCashiersIds);
        $usedPaymentMethodsIds = array_unique($usedPaymentMethodsIds);
        $usedPaymentMethodTypes = array_unique($usedPaymentMethodTypes);

        if (null !== $cashier) {
            $shiftCashiersIds = [$cashier->getId()];

            /* @var Payment[] $filteredPayments */
            $filteredPayments = [];

            foreach ($payments as $payment) {
                if ($payment->getCashier()->getId() === $cashier->getId()) {
                    $filteredPayments[] = $payment;
                }
            }

            $payments = $filteredPayments;
        }

        /* @var PaymentMethod[] $methods */
        $methods = $entityManager->createQuery(
            'SELECT m from App\Entity\PaymentMethod m
            WHERE m.id IN (:ids)
            ORDER BY m.id ASC'
        )->setParameter('ids', $usedPaymentMethodsIds, ArrayParameterType::INTEGER)
            ->getResult();

        /* @var User[] $shiftCashiers */
        $shiftCashiers = $entityManager->createQuery(
            'SELECT u FROM App\Entity\User u
                WHERE u.id IN (:ids)
                ORDER BY u.firstName ASC'
        )->setParameter('ids', $shiftCashiersIds, ArrayParameterType::INTEGER)
            ->getResult();

        $data = [];

        $grandTotal = 0;

        foreach ($shiftCashiers as $shiftCashier) {
            $total = 0;
            $items = [];

            /* @var Payment[] $transactions */
            $transactions = [];

            foreach ($payments as $payment) {
                //                if ($cashier === null) {
                //                    $transactions[] = $payment;
                //                }
                if ($payment->getCashier()->getId() === $shiftCashier->getId()) {
                    $transactions[] = $payment;
                }
            }

            foreach ($usedPaymentMethodTypes as $usedPaymentMethodType) {
                $amount = 0;
                /* @var Payment[] $filteredPayments */
                $filteredPayments = [];

                foreach ($transactions as $transaction) {
                    if ($transaction->getMethod()->getType()->value === $usedPaymentMethodType) {
                        $filteredPayments[] = $transaction;
                        $amount += $transaction->getTendered();
                    }
                }

                $items[] = [
                    'type' => $usedPaymentMethodType,
                    'transactions' => count($filteredPayments),
                    'amount' => $amount,
                ];

                $total += $amount;
            }

            $data[] = [
                'cashier' => $shiftCashier,
                'items' => $items,
                'transactions' => count($transactions),
                'total' => $total,
            ];

            $grandTotal += $total;
        }

        return [
            'start' => $start,
            'end' => $end,
            'data' => $data,
            'transactions' => count($payments),
            'total' => $grandTotal,
        ];
    }

    public function generatePaymentReport(
        ?User $cashier,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        EntityManagerInterface $entityManager,
    ): array {
        /** @var Payment[] $payments * */
        $payments = $entityManager->createQuery(
            'SELECT p FROM App\Entity\Payment p
                WHERE p.createdAt >= :start AND p.createdAt <= :end
                ORDER BY p.id ASC'
        )->setParameters([
            'start' => $start->format('Y-m-d H:i:s'),
            'end' => $end->format('Y-m-d H:i:s'),
        ])->getResult();

        $grandTotal = 0;

        $transactions = [];

        if (null === $cashier) {
            $shiftCashierIds = [];

            foreach ($payments as $payment) {
                $shiftCashierIds[] = $payment->getCashier()->getId();
            }

            $shiftCashierIds = array_unique($shiftCashierIds);

            /** @var User[] $cashiers * */
            $shiftCashiers = $entityManager->createQuery(
                'SELECT u FROM App\Entity\User u
                WHERE u.id IN (:shiftCashierIds)
                ORDER BY u.firstName ASC'
            )->setParameter('shiftCashierIds', $shiftCashierIds)
                ->getResult();

            foreach ($shiftCashiers as $shiftCashier) {
                $cashierTransactions = [];
                $total = 0;

                foreach ($payments as $payment) {
                    if ($payment->getCashier()->getId() === $shiftCashier->getId()) {
                        $cashierTransactions[] = $payment;
                        $total += $payment->getTendered();
                    }
                }

                $transactions[] = [
                    'cashier' => $shiftCashier,
                    'total' => $total,
                    'transactions' => $cashierTransactions,
                ];

                $grandTotal += $total;
            }
        } else {
            $cashierTransactions = [];
            $total = 0;

            foreach ($payments as $payment) {
                if ($payment->getCashier()->getId() === $cashier->getId()) {
                    $cashierTransactions[] = $payment;
                    $total += $payment->getTendered();
                }
            }

            $transactions[] = [
                'cashier' => $cashier,
                'total' => $total,
                'transactions' => $cashierTransactions,
            ];

            $grandTotal += $total;
        }

        return [
            'start' => $start,
            'end' => $end,
            'totals' => $grandTotal,
            'data' => $transactions,
        ];
    }
}

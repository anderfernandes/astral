<?php

namespace App\Repository;

use App\Entity\Membership;
use App\Entity\Sale;
use App\Entity\SaleItem;
use App\Entity\User;
use App\Enums\MemberPosition;
use App\Enums\SaleItemType;
use App\Model\PaymentDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sale>
 */
class SaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sale::class);
    }

    /**
     * @param PaymentDto[] $payments
     */
    public function createFromMembership(
        Membership $membership,
        array $payments,
        User $creator): void
    {
        $sale = new Sale(
            creator: $creator,
            customer: $membership->getPrimary()->getUser(),
        );

        $item = new SaleItem(
            price: $membership->getType()->getPrice(),
            quantity: 1,
            meta: [
                'membershipTypeId' => $membership->getType()->getId(),
                'userId' => $membership->getPrimary()->getId(),
                'position' => MemberPosition::PRIMARY,
            ],
            type: SaleItemType::Membership
        );

        $this->getEntityManager()->persist($item);

        $sale->addItem($item);

        foreach ($membership->getSecondaries() as $member) {
            if (MemberPosition::PRIMARY === $member->getPosition()) {
                continue;
            }

            $secondaryItem = new SaleItem(
                price: MemberPosition::PAID_SECONDARY === $member->getPosition() ? $membership->getType()->getSecondaryPrice() : 0,
                quantity: 1,
                meta: [
                    'membershipTypeId' => $membership->getType()->getId(),
                    'userId' => $member->getUser()->getId(),
                    'position' => $member->getPosition(),
                ],
                type: SaleItemType::Membership
            );

            $this->getEntityManager()->persist($secondaryItem);

            $sale->addItem($secondaryItem);
        }

        foreach ($payments as $paymentDto) {
            /** @var ?\App\Entity\PaymentMethod $method */
            $method = $this->getEntityManager()->getRepository(\App\Entity\PaymentMethod::class)->find($paymentDto->methodId);

            $payment = new \App\Entity\Payment(
                cashier: $creator,
                customer: $membership->getPrimary()->getUser(),
                method: $method,
                tendered: $paymentDto->tendered
            );

            $this->getEntityManager()->persist($payment);

            $sale->addPayment($payment);
        }

        if (0 !== $sale->getBalance()) {
            throw new \Exception('Balance is '.$sale->getBalance().' but it should be 0');
        }

        $this->getEntityManager()->persist($sale);

        $this->getEntityManager()->flush();
    }

    //    /**
    //     * @return Sale[] Returns an array of Sale objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Sale
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\Membership;
use App\Enums\MemberPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Membership>
 */
class MembershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membership::class);
    }

    /**
     * @param array{free: int[], paid: int[]} $secondaries
     */
    public function create(
        int $primary,
        array $secondaries,
        int $typeId,
        int $starting,
        ?\App\Entity\User $creator,
    ): Membership {
        if (null == $primary) {
            throw new \Exception('Invalid primary.');
        }

        // TODO: MAKE SURE FREE AND PAID DON'T HAVE THE SAME VALUES
        $free = array_key_exists('free', $secondaries) && null != $secondaries['free']
            ? array_unique($secondaries['free'])
            : [];
        $paid = array_key_exists('paid', $secondaries) && null != $secondaries['paid']
            ? array_unique($secondaries['paid'])
            : [];

        /** @var int[] */
        $ids = [$primary, ...$free, ...$paid];

        if (count($ids) <= 0) {
            throw new \Exception('Membership needs a primary.');
        }

        /** @var ?\App\Entity\MembershipType $type */
        $type = $this->getEntityManager()->getRepository(\App\Entity\MembershipType::class)->find($typeId);

        if (null === $type) {
            throw new \Exception('Invalid membership type.');
        }

        if (count($free) > $type->getMaxFreeSecondaries()) {
            throw new \Exception($type->getName().' membership cannot have more than '.$type->getMaxFreeSecondaries().' free secondaries, '.count($free).' selected.');
        }

        if (count($paid) > $type->getMaxPaidSecondaries()) {
            throw new \Exception($type->getName().' membership cannot have more than '.$type->getMaxPaidSecondaries().' paid secondaries, '.count($paid).' selected.');
        }

        /** @var UserRepository $userRepository */
        $userRepository = $this->getEntityManager()->getRepository(\App\Entity\User::class);

        $users = $userRepository->getUsersByIds(array_unique($ids));

        if (count($users) <= 0) {
            throw new \Exception('Membership requires all members to be users.');
        }

        $duration = $type->getDuration();

        $membership = new Membership($creator);

        foreach ($users as $user) {
            $member = new \App\Entity\Member();
            $member->setUser($user);
            $member->setType($type);

            if ($user->getId() === $primary) {
                $member->setPosition(MemberPosition::PRIMARY);
            } elseif (in_array($user->getId(), $free)) {
                $member->setPosition(MemberPosition::FREE_SECONDARY);
            } elseif (in_array($user->getId(), $paid)) {
                $member->setPosition(MemberPosition::PAID_SECONDARY);
            }

            $member->setStarting(new \DateTimeImmutable()->setTimestamp($starting));
            $member->setEnding(new \DateTimeImmutable()->setTimestamp($starting)->modify("+$duration days"));

            $this->getEntityManager()->persist($member);

            $membership->addMember($member);
        }

        // $this->getEntityManager()->persist($membership);

        return $membership;
    }

    //    /**
    //     * @return Membership[] Returns an array of Membership objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Membership
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

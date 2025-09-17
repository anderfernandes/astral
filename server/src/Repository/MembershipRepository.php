<?php

namespace App\Repository;

use App\Entity\Member;
use App\Entity\Membership;
use App\Enums\MemberPosition;
use App\Model\MembershipDto;
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

    public function create(
        MembershipDto $membershipDto,
        ?\App\Entity\User $creator,
    ): Membership {
        if (null == $membershipDto->primary) {
            throw new \Exception('Invalid primary.');
        }

        if (!empty(array_intersect($membershipDto->free, $membershipDto->paid))) {
            throw new \Exception('A user cannot be a free and paid secondary at the same time.');
        }

        $free = array_unique($membershipDto->free);
        $paid = array_unique($membershipDto->paid);

        /** @var int[] */
        $ids = [$membershipDto->primary, ...$membershipDto->free, ...$membershipDto->paid];

        if (count($ids) <= 0) {
            throw new \Exception('Membership needs a primary.');
        }

        /** @var ?\App\Entity\MembershipType $type */
        $type = $this->getEntityManager()->getRepository(\App\Entity\MembershipType::class)->find($membershipDto->typeId);

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
            $member = new Member(
                type: $type,
                user: $user,
                starting: new \DateTimeImmutable()
            );

            if ($user->getId() === $membershipDto->primary) {
                $member->setPosition(MemberPosition::PRIMARY);
            } elseif (in_array($user->getId(), $free)) {
                $member->setPosition(MemberPosition::FREE_SECONDARY);
            } elseif (in_array($user->getId(), $paid)) {
                $member->setPosition(MemberPosition::PAID_SECONDARY);
            }

            $this->getEntityManager()->persist($member);

            $membership->addMember($member);
        }

        $this->getEntityManager()->persist($membership);

        return $membership;
    }

    public function update(Membership $membership, MembershipDto $membershipDto): Membership
    {
        $ids = [
            $membership->getPrimary()->getUser()->getId(),
            ...$membershipDto->free,
            ...$membershipDto->paid,
        ];

        /** @var ?\App\Entity\MembershipType $type */
        $type = $this->getEntityManager()->getRepository(\App\Entity\MembershipType::class)->find($membershipDto->typeId);

        if (null === $type) {
            throw new \Exception('Invalid membership type.');
        }

        if (count($membershipDto->free) > $type->getMaxFreeSecondaries()) {
            throw new \Exception($type->getName().' membership cannot have more than '.$type->getMaxFreeSecondaries().' free secondaries, '.count($membershipDto->free).' selected.');
        }

        if (count($membershipDto->paid) > $type->getMaxPaidSecondaries()) {
            throw new \Exception($type->getName().' membership cannot have more than '.$type->getMaxPaidSecondaries().' paid secondaries, '.count($membershipDto->paid).' selected.');
        }

        /** @var UserRepository $userRepository */
        $userRepository = $this->getEntityManager()->getRepository(\App\Entity\User::class);

        $users = $userRepository->getUsersByIds(array_unique($ids));

        if (count($users) <= 0) {
            throw new \Exception('Membership requires all members to be users.');
        }

        $duration = $type->getDuration();

        foreach ($users as $user) {
            $member = new Member(
                type: $type,
                user: $user,
                starting: (new \DateTimeImmutable())->setTimestamp($membershipDto->starting)
            );

            if ($user->getId() === $membership->getPrimary()->getUser()->getId()) {
                $member->setPosition(MemberPosition::PRIMARY);
            } elseif (in_array($user->getId(), $membershipDto->free)) {
                $member->setPosition(MemberPosition::FREE_SECONDARY);
            } elseif (in_array($user->getId(), $membershipDto->paid)) {
                $member->setPosition(MemberPosition::PAID_SECONDARY);
            }

            $this->getEntityManager()->persist($member);

            $membership->addMember($member);
        }

        $membership->setUpdatedAt(new \DateTimeImmutable());

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

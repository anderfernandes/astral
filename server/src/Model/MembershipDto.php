<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class MembershipDto
{
    /**
     * @param int[]                                      $free
     * @param int[]                                      $paid
     * @param array<array{methodId: int, tendered: int}> $payments
     */
    public function __construct(
        #[Assert\NotBlank, Assert\NotNull]
        public int $typeId,

        #[Assert\NotBlank, Assert\NotNull]
        public int $starting,

        #[Assert\Type('array'), Assert\Unique, Assert\NotNull]
        public array $payments,

        #[Assert\Type('array'), Assert\Unique]
        public array $free = [],

        #[Assert\Type('array'), Assert\Unique]
        public array $paid = [],

        public ?int $primary = null,
    ) {
    }
}

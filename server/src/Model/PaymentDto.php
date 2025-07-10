<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class PaymentDto
{
    public function __construct(
        #[Assert\NotBlank, Assert\NotNull]
        public int $tendered,

        #[Assert\NotBlank, Assert\NotNull]
        public int $methodId,
    ) {
    }
}

<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $email,

        #[Assert\NotBlank]
        public string $password,

        #[Assert\NotBlank]
        public string $firstName,

        #[Assert\NotBlank]
        public string $lastName,

        #[Assert\NotBlank]
        public string $address,

        #[Assert\NotBlank]
        public string $city,

        #[Assert\NotBlank]
        public string $state,

        #[Assert\NotBlank]
        public string $zip,

        #[Assert\NotBlank]
        public string $country,

        #[Assert\NotBlank]
        public string $phone,

        #[Assert\NotBlank]
        public \DateTimeImmutable $dateOfBirth,
    ) {
    }
}

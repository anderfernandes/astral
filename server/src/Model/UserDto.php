<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    public function __construct(
        #[Assert\EqualTo(
            propertyPath: 'emailConfirmation',
            message: 'Email confirmation must match'
        )]
        public string $email,
        public string $emailConfirmation,
        public string $firstName,
        public string $lastName,
        public ?string $password,
        public ?string $passwordConfirmation,
        public ?string $address,
        public ?string $city,
        public ?string $state,
        public ?string $zip,
        public ?string $country,
        public ?string $phone,
        public ?\DateTimeImmutable $dateOfBirth,
    ) {
    }
}

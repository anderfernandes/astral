<?php

namespace App\Model;

class ShowDto
{
    public function __construct(
        public string $name,
        public int $typeId,
        public int $duration,
        public string $description,
        public ?bool $isActive = false,
        public ?string $trailerUrl,
        public ?\DateTimeInterface $expiration,
    ) {
    }
}

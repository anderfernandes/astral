<?php

namespace App\Model;

class EventDto
{
    public function __construct(
        public \DateTimeInterface $starting,
        public int $seats,
        public int $typeId,
        public ?\DateTimeInterface $ending,
        public ?array $shows,
        public ?bool $isPublic = false,
        )
    {
    }
}
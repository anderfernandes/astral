<?php

namespace App\Model;

class EventDto
{
    public function __construct(
        public int $starting,
        public int $seats,
        public int $typeId,
        public ?int $ending,
        public ?array $shows,
        public ?bool $isPublic = false,
    ) {
    }
}

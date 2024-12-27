<?php

namespace App\Model;

class EventTypeDto
{
    public function __construct(
        public string $name,
        public string $description,
        public ?string $color = 'white',
        public ?string $backgroundColor = 'black',
        public ?bool $isPublic = false,
        public ?bool $isActive = false
    ) {
    }
}

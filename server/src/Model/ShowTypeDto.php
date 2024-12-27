<?php

namespace App\Model;

class ShowTypeDto
{
    public function __construct(
        public string $name,
        public string $description,
        public ?bool $isActive,
    ) {
    }
}

<?php

namespace App\Model;

class EventTypeDto
{
    public function __construct(
        public string $name,
        public string $description,
        public string $color,
        public string $backgroundColor,
        public bool $isPublic,
        )
    {

    }
}
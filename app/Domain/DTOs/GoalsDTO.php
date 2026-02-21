<?php

namespace App\Domain\DTOs;

final readonly class GoalsDTO
{
    public function __construct(
        public ?int $home,
        public ?int $away,
    ) {}
}
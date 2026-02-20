<?php

namespace App\Domain\Dtos;

final readonly class GoalsDTO
{
    public function __construct(
        public ?int $home,
        public ?int $away,
    ) {}
}
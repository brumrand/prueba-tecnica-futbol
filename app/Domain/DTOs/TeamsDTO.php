<?php

namespace App\Domain\DTOs;

final readonly class TeamSideDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $logo,
        public ?bool $winner,
    ) {}
}

final readonly class TeamsDTO
{
    public function __construct(
        public TeamSideDTO $home,
        public TeamSideDTO $away,
    ) {}
}
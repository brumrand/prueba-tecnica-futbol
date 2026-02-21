<?php

namespace App\Domain\DTOs;

final readonly class TeamDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $code,
        public string $country,
        public int $founded,
        public bool $national,
        public string $logo,
    ) {}
}
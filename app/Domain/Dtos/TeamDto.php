<?php

namespace App\Domain\Dtos;

final readonly class TeamDto
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
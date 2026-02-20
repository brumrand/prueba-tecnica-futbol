<?php

namespace App\Domain\Dtos;

final readonly class LeagueDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $country,
        public string $logo,
        public string $flag,
        public int $season,
        public string $round,
    ) {}
}
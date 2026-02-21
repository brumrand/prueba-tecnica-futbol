<?php

namespace App\Domain\DTOs;

final readonly class PeriodsDTO
{
    public function __construct(
        public int $first,
        public ?int $second,
    ) {}
}

final readonly class FixtureVenueDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $city,
    ) {}
}

final readonly class StatusDTO
{
    public function __construct(
        public string $long,
        public string $short,
        public int $elapsed,
        public ?int $extra,
    ) {}
}

final readonly class FixtureDTO
{
    public function __construct(
        public int $id,
        public ?string $referee,
        public string $timezone,
        public string $date,
        public int $timestamp,
        public PeriodsDTO $periods,
        public FixtureVenueDTO $venue,
        public StatusDTO $status,
    ) {}
}
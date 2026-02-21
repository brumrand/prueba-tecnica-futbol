<?php

namespace App\Domain\DTOs;

final readonly class ScoreSideDTO
{
    public function __construct(
        public ?int $home,
        public ?int $away,
    ) {}
}

final readonly class ScoreDTO
{
    public function __construct(
        public ScoreSideDTO $halftime,
        public ScoreSideDTO $fulltime,
        public ScoreSideDTO $extratime,
        public ScoreSideDTO $penalty,
    ) {}
}
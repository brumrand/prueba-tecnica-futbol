<?php

namespace App\Domain\DTOs;

final readonly class MatchDTO
{
    public function __construct(
        public FixtureDTO $fixture,
        public LeagueDTO $league,
        public TeamsDTO $teams,
        public GoalsDTO $goals,
        public ScoreDTO $score,
    ) {}
}
<?php

namespace App\External\FootballApi\Mappers;

use App\Domain\DTOs\MatchDTO;
use App\Domain\DTOs\FixtureDTO;
use App\Domain\DTOs\PeriodsDTO;
use App\Domain\DTOs\FixtureVenueDTO;
use App\Domain\DTOs\StatusDTO;
use App\Domain\DTOs\LeagueDTO;
use App\Domain\DTOs\TeamsDTO;
use App\Domain\DTOs\TeamSideDTO;
use App\Domain\DTOs\GoalsDTO;
use App\Domain\DTOs\ScoreDTO;
use App\Domain\DTOs\ScoreSideDTO;
use Log;

final class MatchMapper
{
    /**
     * @return MatchDTO[]
     */
    public static function fromApi(array $response): array
    {
        return collect($response)
            ->map(fn (array $item) => self::mapMatch($item))
            ->all();
    }

    private static function mapMatch(array $data): MatchDTO
    {
        return new MatchDTO(
            fixture: new FixtureDTO(
                id: $data['fixture']['id'],
                referee: $data['fixture']['referee'],
                timezone: $data['fixture']['timezone'],
                date: $data['fixture']['date'],
                timestamp: $data['fixture']['timestamp'],
                periods: new PeriodsDTO(
                    first: $data['fixture']['periods']['first'],
                    second: $data['fixture']['periods']['second'],
                ),
                venue: new FixtureVenueDTO(
                    id: $data['fixture']['venue']['id'],
                    name: $data['fixture']['venue']['name'],
                    city: $data['fixture']['venue']['city'],
                ),
                status: new StatusDTO(
                    long: $data['fixture']['status']['long'],
                    short: $data['fixture']['status']['short'],
                    elapsed: $data['fixture']['status']['elapsed'],
                    extra: $data['fixture']['status']['extra'],
                ),
            ),

            league: new LeagueDTO(
                id: $data['league']['id'],
                name: $data['league']['name'],
                country: $data['league']['country'],
                logo: $data['league']['logo'],
                flag: $data['league']['flag'],
                season: $data['league']['season'],
                round: $data['league']['round'],
            ),

            teams: new TeamsDTO(
                home: new TeamSideDTO(
                    id: $data['teams']['home']['id'],
                    name: $data['teams']['home']['name'],
                    logo: $data['teams']['home']['logo'],
                    winner: $data['teams']['home']['winner'],
                ),
                away: new TeamSideDTO(
                    id: $data['teams']['away']['id'],
                    name: $data['teams']['away']['name'],
                    logo: $data['teams']['away']['logo'],
                    winner: $data['teams']['away']['winner'],
                ),
            ),

            goals: new GoalsDTO(
                home: $data['goals']['home'],
                away: $data['goals']['away'],
            ),

            score: new ScoreDTO(
                halftime: new ScoreSideDTO(
                    home: $data['score']['halftime']['home'],
                    away: $data['score']['halftime']['away'],
                ),
                fulltime: new ScoreSideDTO(
                    home: $data['score']['fulltime']['home'],
                    away: $data['score']['fulltime']['away'],
                ),
                extratime: new ScoreSideDTO(
                    home: $data['score']['extratime']['home'],
                    away: $data['score']['extratime']['away'],
                ),
                penalty: new ScoreSideDTO(
                    home: $data['score']['penalty']['home'],
                    away: $data['score']['penalty']['away'],
                ),
            ),
        );
    }
}
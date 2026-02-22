<?php

namespace App\Http\Controllers;

use App\Domain\Services\FavoriteTeamService;
use App\Domain\Services\FootballDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Log;

class DashboardController extends Controller
{
    public function __construct(
        private readonly FavoriteTeamService $favoriteTeamService,
        private readonly FootballDataService $footballDataService
    ) {
    }

    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $favoriteTeams = $this->favoriteTeamService->getFavoriteTeams($user->id);
        $matchData = $this->footballDataService->getTeamsMatches($favoriteTeams);
        $matchData = $this->fakeLiveFixtures();

        $teamsData = [];
        foreach ($favoriteTeams as $team) {
            $teamData = $this->footballDataService->getTeamById($team);

            if ($teamData) {
                $teamsData[] = $teamData;
            }
        }

        return Inertia::render('dashboard', [
            'favoriteTeams' => $teamsData,
            'matchData'     => $matchData,
        ]);
    }


    private function fakeLiveFixtures(): array
{
    return [
    [
        "fixture" => [
            "id" => 1001,
            "referee" => "Juan Martínez",
            "timezone" => "UTC",
            "date" => "2025-02-20T19:00:00Z",
            "venue" => [
                "id" => 10,
                "name" => "Camp Nou",
                "city" => "Barcelona",
            ],
            "status" => [
                "long" => "Match Finished",
                "short" => "FT",
                "elapsed" => 90,
                "extra" => null,
            ],
        ],
        "league" => [
            "id" => 140,
            "name" => "La Liga",
            "country" => "Spain",
            "logo" => "https://media.api-sports.io/football/leagues/140.png",
            "round" => "Regular Season - 25",
            "season" => 2024,
            "standings" => true,
        ],
        "teams" => [
            "home" => [
                "id" => 529,
                "name" => "Barcelona",
                "logo" => "https://media.api-sports.io/football/teams/529.png",
                "winner" => true,
            ],
            "away" => [
                "id" => 541,
                "name" => "Real Madrid",
                "logo" => "https://media.api-sports.io/football/teams/541.png",
                "winner" => false,
            ],
        ],
        "goals" => [
            "home" => 2,
            "away" => 1,
        ],
        "score" => [
            "halftime" => [
                "home" => 1,
                "away" => 1,
            ],
            "fulltime" => [
                "home" => 2,
                "away" => 1,
            ],
            "extratime" => null,
            "penalty" => null,
        ],
    ],
    [
        "fixture" => [
            "id" => 1002,
            "referee" => null,
            "timezone" => "UTC",
            "date" => "2025-02-22T21:30:00Z",
            "venue" => [
                "id" => 22,
                "name" => "Old Trafford",
                "city" => "Manchester",
            ],
            "status" => [
                "long" => "Match Postponed",
                "short" => "PST",
                "elapsed" => null,
                "extra" => null,
            ],
        ],
        "league" => [
            "id" => 39,
            "name" => "Premier League",
            "country" => "England",
            "logo" => "https://media.api-sports.io/football/leagues/39.png",
            "round" => "Regular Season - 26",
            "season" => 2024,
            "standings" => true,
        ],
        "teams" => [
            "home" => [
                "id" => 33,
                "name" => "Manchester United",
                "logo" => "https://media.api-sports.io/football/teams/33.png",
                "winner" => null,
            ],
            "away" => [
                "id" => 50,
                "name" => "Manchester City",
                "logo" => "https://media.api-sports.io/football/teams/50.png",
                "winner" => null,
            ],
        ],
        "goals" => [
            "home" => null,
            "away" => null,
        ],
        "score" => [
            "halftime" => [
                "home" => null,
                "away" => null,
            ],
            "fulltime" => [
                "home" => null,
                "away" => null,
            ],
            "extratime" => null,
            "penalty" => null,
        ],
    ],
];
}


    
}

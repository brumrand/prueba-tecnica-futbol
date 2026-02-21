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
        $matchData = $this->fakeLiveFixtures();

        $teamsData = [];
        foreach ($favoriteTeams as $team) {
            // $teamData = $this->footballDataService->getTeamById($team);
            $teamData= [
                    'id' => $team,
                    'name' => 'Manchester United',
                    'code' => 'MUN',
                    'country' => 'England',
                    'founded' => 1878,
                    'national' => false,
                    'logo' => 'https://media.api-sports.io/football/teams/33.png',
            ];
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
            'id' => 239625,
            'date' => '2025-02-06T14:00:00+00:00',
            'status' => 'HT',
            'league' => [
                'name' => 'Premier League',
                'country' => 'England',
                'logo' => 'https://media.api-sports.io/football/leagues/39.png',
                'round' => 'Regular Season - 24',
            ],
            'venue' => [
                'name' => 'Old Trafford',
                'city' => 'Manchester',
            ],
            'teams' => [
                'home' => [
                    'id' => 33,
                    'name' => 'Manchester United',
                    'logo' => 'https://media.api-sports.io/football/teams/33.png',
                    'winner' => null,
                ],
                'away' => [
                    'id' => 50,
                    'name' => 'Manchester City',
                    'logo' => 'https://media.api-sports.io/football/teams/50.png',
                    'winner' => null,
                ],
            ],
            'score' => [
                'halftime' => [
                    'home' => 1,
                    'away' => 1,
                ],
                'fulltime' => [
                    'home' => null,
                    'away' => null,
                ],
            ],
        ],
        [
            'id' => 239626,
            'date' => '2025-02-06T16:30:00+00:00',
            'status' => 'NS',
            'league' => [
                'name' => 'La Liga',
                'country' => 'Spain',
                'logo' => 'https://media.api-sports.io/football/leagues/140.png',
                'round' => 'Regular Season - 22',
            ],
            'venue' => [
                'name' => 'Santiago Bernabéu',
                'city' => 'Madrid',
            ],
            'teams' => [
                'home' => [
                    'id' => 541,
                    'name' => 'Real Madrid',
                    'logo' => 'https://media.api-sports.io/football/teams/541.png',
                    'winner' => null,
                ],
                'away' => [
                    'id' => 529,
                    'name' => 'Barcelona',
                    'logo' => 'https://media.api-sports.io/football/teams/529.png',
                    'winner' => null,
                ],
            ],
            'score' => [
                'halftime' => [
                    'home' => null,
                    'away' => null,
                ],
                'fulltime' => [
                    'home' => null,
                    'away' => null,
                ],
            ],
        ],
    ];
}


    
}

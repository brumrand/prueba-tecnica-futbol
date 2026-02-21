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
        Log::info("User {$user->id} has favorite teams: " . implode(', ', $favoriteTeams));
        $teamsData = [];
        foreach ($favoriteTeams as $team) {
            $teamData = $this->footballDataService->getTeamById($team);
            if ($teamData) {
                $teamsData[] = $teamData;
            }
        }

        return Inertia::render('dashboard', [
            'favoriteTeams' => $teamsData,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Domain\Services\FavoriteTeamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteTeamController extends Controller
{
    public function __construct(private readonly FavoriteTeamService $favoriteTeamService)
    {
    }

    public function destroy(Request $request, int $teamId)
    {
        $user = Auth::user();
        $this->favoriteTeamService->removeFavoriteTeam($user->id, $teamId);

        return redirect()->back();
    }

        public function add(Request $request, int $teamId)
    {
        $user = Auth::user();
        $this->favoriteTeamService->addFavoriteTeam($user->id, $teamId);

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Domain\Services\FootballDataService;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    public function __construct(private readonly FootballDataService $footballDataService)
    {
    }

    public function searchByName(string $name): JsonResponse
    {
        $teams = $this->footballDataService->getTeamsByName($name);
        return response()->json($teams);
    }

}

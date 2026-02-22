<?php

namespace App\Http\Controllers;

use App\Domain\Services\FootballDataService;
use Illuminate\Http\JsonResponse;
use Log;
use App\Http\Requests\SearchByNameReq;
class TeamController extends Controller
{
    public function __construct(private readonly FootballDataService $footballDataService)
    {
    }

    public function searchByName(SearchByNameReq $request, ): JsonResponse
    {
        $name = $request->validated()['name'];
        $teams = $this->footballDataService->getTeamsByName($name);
    
        return response()->json($teams);
    }

}

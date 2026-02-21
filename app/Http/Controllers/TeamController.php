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

    public function searchByName(SearchByNameReq $request,): JsonResponse
    {
        $name = $request->validated()['name'];
        //$teams = $this->footballDataService->getTeamsByName($name);
        $teams = [[
                    'id' => 23,
                    'name' => 'Manchester United',
                    'code' => 'MUN',
                    'country' => 'England',
                    'founded' => 1878,
                    'national' => false,
                    'logo' => 'https://media.api-sports.io/football/teams/33.png',
        ],[
                    'id' => 25,
                    'name' => 'Liverpool',
                    'code' => 'LIV',
                    'country' => 'England',
                    'founded' => 1892,
                    'national' => false,
                    'logo' => 'https://media.api-sports.io/football/teams/28.png',
            ]];
            Log::info('Teams found', ['teams' => $teams]);
        return response()->json($teams);
    }

}

<?php

namespace App\Http\Controllers;

use App\Domain\Services\FootballDataService;

class TeamController extends Controller
{
    public function __construct(private readonly FootballDataService $footballDataService)
    {
    }

}

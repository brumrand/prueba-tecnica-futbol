<?php

namespace Tests\Feature;

use App\Domain\Services\FootballDataService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_search_teams_by_name(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $searchQuery = 'test';
        $expectedTeams = [
            ['id' => 1, 'name' => 'Test Team 1'],
            ['id' => 2, 'name' => 'Test Team 2'],
        ];

        $footballDataServiceMock = $this->mock(FootballDataService::class);
        $footballDataServiceMock->shouldReceive('getTeamsByName')
            ->once()
            ->with($searchQuery)
            ->andReturn($expectedTeams);

        $response = $this->get(route('teams.searchByName', ['name' => $searchQuery]));

        $response->assertStatus(200);
        $response->assertJson($expectedTeams);
    }
}

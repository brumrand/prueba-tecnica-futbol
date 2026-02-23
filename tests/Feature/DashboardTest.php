<?php

namespace Tests\Feature;

use App\Domain\Services\FavoriteTeamService;
use App\Domain\Services\FootballDataService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Mockery;
use Tests\TestCase;
use App\Domain\DTOs\TeamDTO;
use App\Domain\DTOs\VenueDTO;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_guests_are_redirected_to_the_login_page()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_visit_the_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_dashboard_shows_favorite_teams_and_matches()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $favoriteTeamIds = [529, 33];
        $teamData1 = [
            'team' => new TeamDTO(529, 'Barcelona', 'FCB', 'Spain', 1899, false, 'logo_url_bcn'),
            'venue' => new VenueDTO(1, 'Camp Nou', 'C. dArístides Maillol, 12', 'Barcelona', 99354, 'grass', 'image_url_cn')
        ];
        $teamData2 = [
            'team' => new TeamDTO(33, 'Manchester United', 'MUN', 'England', 1878, false, 'logo_url_mu'),
            'venue' => new VenueDTO(2, 'Old Trafford', 'Sir Matt Busby Way', 'Manchester', 74879, 'grass', 'image_url_ot')
        ];

        $favoriteTeamServiceMock = Mockery::mock(FavoriteTeamService::class);
        $favoriteTeamServiceMock->shouldReceive('getFavoriteTeams')->with($user->id)->andReturn($favoriteTeamIds);
        $this->app->instance(FavoriteTeamService::class, $favoriteTeamServiceMock);

        $footballDataServiceMock = Mockery::mock(FootballDataService::class);
        $footballDataServiceMock->shouldReceive('getTeamById')->with(529)->andReturn($teamData1);
        $footballDataServiceMock->shouldReceive('getTeamById')->with(33)->andReturn($teamData2);
        $footballDataServiceMock->shouldReceive('getTeamsMatches')->with($favoriteTeamIds)->andReturn([]); // It will be overwritten
        $this->app->instance(FootballDataService::class, $footballDataServiceMock);

        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertInertia(function (AssertableInertia $page) use ($teamData1, $teamData2) {
            $page->component('dashboard')
                ->has('favoriteTeams', 2)
                ->where('favoriteTeams.0.team.id', $teamData1['team']->id)
                ->where('favoriteTeams.0.team.name', $teamData1['team']->name)
                ->where('favoriteTeams.0.venue.name', $teamData1['venue']->name)
                ->where('favoriteTeams.1.team.id', $teamData2['team']->id)
                ->where('favoriteTeams.1.team.name', $teamData2['team']->name)
                ->where('favoriteTeams.1.venue.name', $teamData2['venue']->name)
                ->has('matchData', 0);
        });
    }

    public function test_it_can_search_teams_by_name_and_they_are_passed_to_the_view(): void
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
        
        $footballDataServiceMock->shouldReceive('getTeamsMatches')->andReturn([]);
        $footballDataServiceMock->shouldReceive('getFavoriteTeams')->andReturn([]);
        $footballDataServiceMock->shouldReceive('getTeamById')->andReturn(null);

        $response = $this->get(route('dashboard', ['search' => $searchQuery]));

        $response->assertStatus(200);

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('dashboard')
                ->has('searchedTeams', 2)
                ->where('searchedTeams', $expectedTeams)
        );
    }
}

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

    public function test_favorite_teams_are_passed_to_the_dashboard()
    {
        $user = User::factory()->create();

        $favoriteTeamServiceMock = Mockery::mock(FavoriteTeamService::class);
        $footballDataServiceMock = Mockery::mock(FootballDataService::class);

        $this->app->instance(FavoriteTeamService::class, $favoriteTeamServiceMock);
        $this->app->instance(FootballDataService::class, $footballDataServiceMock);

        $favoriteTeams = collect([
            (object)['team_id' => 1],
            (object)['team_id' => 2],
        ]);

        $team1 = new TeamDTO(1, 'Team 1', 'logo1.png', 'Country 1', 1900, new VenueDTO(1, 'Venue 1', 'Address 1', 'City 1', 10000, 'Grass', 'image1.png'));
        $team2 = new TeamDTO(2, 'Team 2', 'logo2.png', 'Country 2', 1901, new VenueDTO(2, 'Venue 2', 'Address 2', 'City 2', 20000, 'Grass', 'image2.png'));

        $favoriteTeamServiceMock->shouldReceive('getFavoriteTeams')->with($user->id)->andReturn($favoriteTeams);
        $footballDataServiceMock->shouldReceive('getTeamById')->with(1)->andReturn($team1);
        $footballDataServiceMock->shouldReceive('getTeamById')->with(2)->andReturn($team2);

        $this->actingAs($user);

        $response = $this->get(route('dashboard'));

        $response->assertInertia(function (AssertableInertia $page) use ($team1, $team2) {
            $page->component('dashboard')
                ->has('favoriteTeams', 2)
                ->where('favoriteTeams.0.id', $team1->id)
                ->where('favoriteTeams.1.id', $team2->id);
        });
    }
}

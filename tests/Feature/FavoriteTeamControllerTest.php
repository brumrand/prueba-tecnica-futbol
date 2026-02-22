<?php

namespace Tests\Feature;

use App\Domain\Services\FavoriteTeamService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTeamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_can_add_a_favorite_team(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $teamId = 123;

        $favoriteTeamServiceMock = $this->mock(FavoriteTeamService::class);
        $favoriteTeamServiceMock->shouldReceive('addFavoriteTeam')->once()->with($user->id, $teamId);

        $response = $this->post(route('favorite-teams.store', ['teamId' => $teamId]));

        $response->assertRedirect();
    }

    public function test_an_authenticated_user_can_remove_a_favorite_team(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $teamId = 123;

        $favoriteTeamServiceMock = $this->mock(FavoriteTeamService::class);
        $favoriteTeamServiceMock->shouldReceive('removeFavoriteTeam')->once()->with($user->id, $teamId);

        $response = $this->delete(route('favorite-teams.destroy', ['teamId' => $teamId]));

        $response->assertRedirect();
    }
}

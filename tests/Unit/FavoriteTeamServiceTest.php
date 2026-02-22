<?php

namespace Tests\Unit;

use App\Domain\Services\FavoriteTeamService;
use App\Models\User;
use App\Models\FavoriteTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTeamServiceTest extends TestCase
{
    use RefreshDatabase;

    private FavoriteTeamService $service;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FavoriteTeamService();
        $this->user = User::factory()->create();
    }

    public function test_it_can_add_a_favorite_team()
    {
        $result = $this->service->addFavoriteTeam($this->user->id, 1);

        $this->assertTrue($result);
        $this->assertDatabaseHas('favorite_teams', [
            'user_id' => $this->user->id,
            'team_id' => 1,
        ]);
    }

    public function test_it_does_not_add_a_duplicate_favorite_team()
    {
        $this->service->addFavoriteTeam($this->user->id, 1);
        $result = $this->service->addFavoriteTeam($this->user->id, 1);

        $this->assertFalse($result);
        $this->assertCount(1, FavoriteTeam::where('user_id', $this->user->id)->get());
    }

    public function test_it_does_not_add_more_than_five_favorite_teams()
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->service->addFavoriteTeam($this->user->id, $i);
        }

        $result = $this->service->addFavoriteTeam($this->user->id, 6);

        $this->assertFalse($result);
        $this->assertCount(5, FavoriteTeam::where('user_id', $this->user->id)->get());
    }

    public function test_it_can_remove_a_favorite_team()
    {
        $this->service->addFavoriteTeam($this->user->id, 1);
        $result = $this->service->removeFavoriteTeam($this->user->id, 1);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('favorite_teams', [
            'user_id' => $this->user->id,
            'team_id' => 1,
        ]);
    }

    public function test_it_does_not_fail_when_removing_a_non_favorite_team()
    {
        $result = $this->service->removeFavoriteTeam($this->user->id, 1);

        $this->assertFalse($result);
    }
}

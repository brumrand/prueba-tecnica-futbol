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

    
}

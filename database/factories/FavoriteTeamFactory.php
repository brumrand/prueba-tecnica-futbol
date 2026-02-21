<?php

namespace Database\Factories;

use App\Models\FavoriteTeam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteTeamFactory extends Factory
{
    protected $model = FavoriteTeam::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'team_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}

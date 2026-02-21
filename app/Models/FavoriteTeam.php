<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteTeam extends Model
{
    protected $table = 'favorite_teams';

    protected $fillable = ['user_id', 'team_id'];

    public $timestamps = true;
}
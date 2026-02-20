<?php
namespace App\Domain\Services;

use App\Models\User;
class FavoriteTeamService
{
    public function addFavoriteTeam(int $userId, int $teamId):bool
    {
        // Lógica para agregar un equipo a los favoritos del usuario
        $user = User::findOrFail($userId);
        $attched = $user->favoriteTeams()->where('team_id', $teamId)->exists();
        if(!$attched){
            if ($user->favoriteTeams()->count() < 5) {
                $user->favoriteTeams()->attach($teamId);
                $attched = true;
            }
        }
        return $attched;

    }

    public function removeFavoriteTeam($userId, $teamId):bool
    {
        // Lógica para eliminar un equipo de los favoritos del usuario
        $user = User::findOrFail($userId);
        $attched = $user->favoriteTeams()->where('team_id', $teamId)->exists();
        if($attched){
            $user->favoriteTeams()->detach($teamId);
        }
        return $attched;
        
    }

    public function getFavoriteTeams($userId)
    {
        $user = User::findOrFail($userId);
        return $user->favoriteTeams;
    }
}
<?php

namespace App\Domain\Services;

use App\Models\FavoriteTeam;

class FavoriteTeamService
{
    /**
     * Agrega un equipo a los favoritos del usuario
     * - Evita duplicados
     * - Limita a 5 equipos
     */
    public function addFavoriteTeam(int $userId, int $teamId): bool
    {
        // Ya existe?
        $exists = FavoriteTeam::where('user_id', $userId)
                              ->where('team_id', $teamId)
                              ->exists();
        if ($exists) return false;

        // Límite 5 equipos
        $count = FavoriteTeam::where('user_id', $userId)->count();
        if ($count >= 5) return false;

        // Insertar nuevo favorito
        FavoriteTeam::create([
            'user_id' => $userId,
            'team_id' => $teamId,
        ]);

        return true;
    }

    /**
     * Elimina un equipo de los favoritos del usuario
     */
    public function removeFavoriteTeam(int $userId, int $teamId): bool
    {
        $fav = FavoriteTeam::where('user_id', $userId)
                           ->where('team_id', $teamId)
                           ->first();

        if (!$fav) return false;

        $fav->delete();
        return true;
    }

    /**
     * Obtiene los IDs de los equipos favoritos del usuario
     */
    public function getFavoriteTeams(int $userId): array
    {
        return FavoriteTeam::where('user_id', $userId)
                           ->pluck('team_id')
                           ->toArray();
    }

    /**
     * Verifica si un equipo es favorito del usuario
     */
    public function isFavorite(int $userId, int $teamId): bool
    {
        return FavoriteTeam::where('user_id', $userId)
                           ->where('team_id', $teamId)
                           ->exists();
    }
}
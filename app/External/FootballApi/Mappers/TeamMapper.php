<?php

namespace App\External\FootBallApi\Mappers;

use App\External\FootBallApi\DTOs\TeamDTO;
use App\External\FootBallApi\DTOs\VenueDTO;

final class TeamMapper
{
    public static function fromApi(array $response): array
    {
        /**
         * La API devuelve un array en response[]
         * Para este endpoint sabemos que viene 1 solo equipo
         */
        $data = $response['response'][0];

        return [
            'team' => new TeamDTO(
                id: $data['team']['id'],
                name: $data['team']['name'],
                code: $data['team']['code'],
                country: $data['team']['country'],
                founded: $data['team']['founded'],
                national: $data['team']['national'],
                logo: $data['team']['logo'],
            ),

            'venue' => new VenueDTO(
                id: $data['venue']['id'],
                name: $data['venue']['name'],
                address: $data['venue']['address'],
                city: $data['venue']['city'],
                capacity: $data['venue']['capacity'],
                surface: $data['venue']['surface'],
                image: $data['venue']['image'],
            ),
        ];
    }
}
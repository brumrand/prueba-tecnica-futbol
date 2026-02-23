<?php

namespace App\Domain\Services;

use App\External\FootballApi\FootballClient;
use App\External\FootballApi\Responses\FootballApiResponse;
use App\External\FootballApi\Mappers\TeamMapper;
use App\External\FootballApi\Mappers\MatchMapper;
use App\Domain\DTOs\TeamDTO;
use App\Domain\DTOs\MatchDTO;
use RuntimeException;
use Log;
class FootballDataService
{
    public function __construct(
        private readonly FootballClient $client
    ) {
    }

    /**
     * @return TeamDTO[]
     */
    public function getTeamsByName(string $name): array
    {
        $response = $this->client->getTeamsByName($name);

        $this->ensureSuccess($response, 'getTeamsByName');
        $teams = [];
        Log::info('API response for getTeamsByName', ['response' => $response]);
        foreach ($response->data as $item) {      
            Log::info('Mapping team from API item', ['item' => $item]);
        $team = TeamMapper::fromApi($item);
        $teams[] = $team['team'];
        }
        return $teams; 
    }

    public function getTeamById(int $teamId): array|null
    {
        $response = $this->client->getTeamById($teamId);
        if (!$response->isSuccess()) {
            $this->logError($response, 'getTeamById');

            return null; 
        }

        return TeamMapper::fromApi($response->data[0]);
        
    }

    /**
     * @return MatchDTO[]
     */
    public function getLiveFixtures(): array
    {
        $response = $this->client->getFixtures(['live' => 'all']);

        if (!$response->isSuccess()) {
            $this->logError($response, 'getLiveFixtures');

            // fallback razonable
            return [];
        }

        return MatchMapper::fromApi($response->data);
    }

    public function getTeamsMatches(array $teamId, int $season = 2024): array
    {
        $results = [];
        foreach ($teamId as $id) {
            $response = $this->client->getFixtures(['team' => $id, 'season' => $season]);
            if (!$response->isSuccess()) {
                $this->logError($response, 'getTeamMatches');
            } else {
                $matches = MatchMapper::fromApi($response->data);
                $results = array_merge($results, $matches);
            }
        }
        usort($results, function ($a, $b) {
            return strtotime($b->fixture->date) <=> strtotime($a->fixture->date);
        });
        return $results;
    }

    /**
     * Política estricta: si falla, lanza excepción
     */
    private function ensureSuccess(
        FootballApiResponse $response,
        string $context
    ): void {
        if ($response->isSuccess()) {
            return;
        }

        $this->logError($response, $context);

        throw new RuntimeException(
            sprintf('Football API error in %s', $context)
        );
    }

    private function logError(
        FootballApiResponse $response,
        string $context
    ): void {
        logger()->error('Football API failure', [
            'context' => $context,
            'http_status' => $response->httpStatus,
            'errors' => $response->errors,
            'meta' => $response->meta,
        ]);
    }
}
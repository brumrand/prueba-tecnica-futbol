<?php

namespace App\Application\Services\Football;

use App\External\FootBallApi\FootballClient;
use App\External\FootBallApi\Responses\FootballApiResponse;
use App\External\FootBallApi\Mappers\TeamMapper;
use App\External\FootBallApi\Mappers\MatchMapper;
use App\Domain\Dtos\TeamDTO;
use App\Domain\Dtos\MatchDTO;
use RuntimeException;

final class FootballDataService
{
    public function __construct(
        private readonly FootballClient $client
    ) {}

    /**
     * @return TeamDTO[]
     */
    public function getTeamsByName(string $name): array
    {
        $response = $this->client->getTeamsByName($name);

        $this->ensureSuccess($response, 'getTeamsByName');

        return TeamMapper::fromApi($response->data);
    }

    public function getTeamById(int $teamId): ?TeamDTO
    {
        $response = $this->client->getTeamById($teamId);

        if (! $response->isSuccess()) {
            $this->logError($response, 'getTeamById');

            return null; // decisión de negocio
        }

        $teams = TeamMapper::fromApi($response->data);

        return $teams[0] ?? null;
    }

    /**
     * @return MatchDTO[]
     */
    public function getLiveFixtures(): array
    {
        $response = $this->client->getFixtures(['live' => 'all']);

        if (! $response->isSuccess()) {
            $this->logError($response, 'getLiveFixtures');

            // fallback razonable
            return [];
        }

        return MatchMapper::fromApi($response->data);
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
            'context'     => $context,
            'http_status' => $response->httpStatus,
            'errors'      => $response->errors,
            'meta'        => $response->meta,
        ]);
    }
}
<?php

namespace App\External\FootballApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use App\External\FootballApi\Responses\FootballApiResponse;
final class FootballClient
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = (string) config('football_api.base_url');
        $this->apiKey  = (string) config('football_api.key');
    }

    public function getTeamsByName(string $name): FootballApiResponse
    {
        return $this->get('teams', ['name' => $name]);
    }

    public function getTeamById(int $teamId): FootballApiResponse
    {
        return $this->get('teams', ['id' => $teamId]);
    }

    public function getFixtures(array $queryParams = []): FootballApiResponse
    {
        return $this->get('fixtures', $queryParams);
    }

    private function get(string $endpoint, array $queryParams = []): FootballApiResponse
    {
        try {
            $response = Http::baseUrl($this->baseUrl)
                ->withHeaders([
                    'x-apisports-key' => $this->apiKey,
                    'Accept'          => 'application/json',
                ])
                ->timeout(10)
                ->retry(2, 200)
                ->get($endpoint, $queryParams);

            return $this->mapResponse($response);

        } catch (RequestException $e) {
            report($e);

            return new FootballApiResponse(
                success: false,
                hasData: false,
                httpStatus: $e->response?->status() ?? 0,
                data: [],
                errors: ['transport_error'],
                meta: []
            );
        }
    }

    private function mapResponse(Response $response): FootballApiResponse
    {
        $json = $response->json() ?? [];
        $hasData = $response->status() !== 204 && isset($json['response']) && count($json['response']) > 0;

        return new FootballApiResponse(
            success: $response->successful() && empty($json['errors']),
            hasData: $hasData,
            httpStatus: $response->status(),
            data: $json['response'] ?? [],
            errors: $json['errors'] ?? [],
            meta: [
                'get'        => $json['get']        ?? null,
                'parameters' => $json['parameters'] ?? [],
                'results'    => $json['results']    ?? 0,
                'paging'     => $json['paging']     ?? [],
            ],
        );
    }
}
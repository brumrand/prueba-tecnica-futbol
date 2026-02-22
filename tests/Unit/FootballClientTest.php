<?php

namespace Tests\Unit;

use App\External\FootballApi\FootballClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FootballClientTest extends TestCase
{
    private string $baseUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = 'https://api-football-v1.p.rapidapi.com/v3/';
        config(['football_api.base_url' => $this->baseUrl]);
        config(['football_api.key' => 'test-api-key']);
    }

    public function test_get_teams_by_name_returns_successful_response()
    {
        $responseData = ['response' => [['team' => ['id' => 1, 'name' => 'Test Team']]]];
        Http::fake([
            $this->baseUrl . '*' => Http::response($responseData, 200),
        ]);

        $client = new FootballClient();
        $response = $client->getTeamsByName('test');

        $this->assertTrue($response->isSuccess());
        $this->assertTrue($response->hasData);
        $this->assertEquals(200, $response->httpStatus);
        $this->assertEquals($responseData['response'], $response->data);
    }

    public function test_get_teams_by_name_returns_error_response_on_http_error()
    {
        Http::fake([
            $this->baseUrl . '*' => Http::response(null, 500),
        ]);

        $client = new FootballClient();
        $response = $client->getTeamsByName('test');

        $this->assertFalse($response->isSuccess());
        $this->assertFalse($response->hasData);
        $this->assertEquals(500, $response->httpStatus);
    }
}

<?php

namespace Tests\Unit;

use App\Domain\DTOs\TeamDTO;
use App\Domain\Services\FootballDataService;
use App\External\FootballApi\FootballClient;
use App\External\FootballApi\Responses\FootballApiResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class FootballDataServiceTest extends TestCase
{
    use WithFaker;

    private FootballClient|Mockery\MockInterface $clientMock;
    private FootballDataService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientMock = Mockery::mock(FootballClient::class);
        $this->service = new FootballDataService($this->clientMock);
    }

    public function test_get_teams_by_name_returns_mapped_teams_on_success()
    {
        $apiData = [
            [
                'team' => ['id' => 1, 'name' => 'Team 1', 'code' => 'T1', 'country' => 'C1', 'founded' => 2000, 'national' => false, 'logo' => 'logo1.png'],
                'venue' => ['id' => 1, 'name' => 'Venue 1', 'address' => 'Addr 1', 'city' => 'City 1', 'capacity' => 10000, 'surface' => 'grass', 'image' => 'venue1.png']
            ],
            [
                'team' => ['id' => 2, 'name' => 'Team 2', 'code' => 'T2', 'country' => 'C2', 'founded' => 2001, 'national' => false, 'logo' => 'logo2.png'],
                'venue' => ['id' => 2, 'name' => 'Venue 2', 'address' => 'Addr 2', 'city' => 'City 2', 'capacity' => 20000, 'surface' => 'grass', 'image' => 'venue2.png']
            ],
        ];
        $apiResponse = new FootballApiResponse(true, true, 200, $apiData, [], []);

        $this->clientMock
            ->shouldReceive('getTeamsByName')
            ->once()
            ->with('test')
            ->andReturn($apiResponse);
        
        $result = $this->service->getTeamsByName('test');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    public function test_get_teams_by_name_throws_exception_on_failure()
    {
        $this->expectException(RuntimeException::class);

        $apiResponse = new FootballApiResponse(false, false, 500, [], ['error' => 'test error'], []);
        
        $this->clientMock
            ->shouldReceive('getTeamsByName')
            ->once()
            ->with('test')
            ->andReturn($apiResponse);

        $this->service->getTeamsByName('test');
    }

    public function test_get_team_by_id_returns_mapped_team_on_success()
    {
        $apiData = [
            [
                'team' => ['id' => 1, 'name' => 'Team 1', 'code' => 'T1', 'country' => 'C1', 'founded' => 2000, 'national' => false, 'logo' => 'logo1.png'],
                'venue' => ['id' => 1, 'name' => 'Venue 1', 'address' => 'Addr 1', 'city' => 'City 1', 'capacity' => 10000, 'surface' => 'grass', 'image' => 'venue1.png']
            ]
        ];
        $apiResponse = new FootballApiResponse(true, true, 200, $apiData, [], []);

        $this->clientMock
            ->shouldReceive('getTeamById')
            ->once()
            ->with(1)
            ->andReturn($apiResponse);

        $result = $this->service->getTeamById(1);

        $this->assertIsArray($result);
    }

    public function test_get_team_by_id_returns_null_on_failure()
    {
        $apiResponse = new FootballApiResponse(false, false, 500, [], ['error' => 'test error'], []);

        $this->clientMock
            ->shouldReceive('getTeamById')
            ->once()
            ->with(1)
            ->andReturn($apiResponse);

        $result = $this->service->getTeamById(1);

        $this->assertNull($result);
    }
}

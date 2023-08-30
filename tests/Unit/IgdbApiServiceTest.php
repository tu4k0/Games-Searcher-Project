<?php


namespace Tests\Unit;

use App\Models\Game;
use App\Services\IgdbExternalApiService;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class IgdbApiServiceTest extends Unit
{
    /**
     * @var \App\Services\IgdbExternalApiService
     */
    protected mixed $igdbExternalApiService;
    /**
     * @var \Tests\Support\UnitTester
     */
    protected UnitTester $tester;
    /**
     * @var string
     */
    protected string $access_token;

    /**
     * @return void
     * @throws \Exception
     */
    protected function _inject(): void
    {
        $this->igdbExternalApiService = $this->make(IgdbExternalApiService::class, [
            'getGames' => function () {
                return Game::factory()->count(10)->make()->toArray();
            },
            'getGameByName' => function ($name) {
                return Game::factory()->makeOne(["name" => $name])->toArray();
            },
            'getAccessToken' => function () {
                return 'zxrfoi491567d5h8824j0j3wcbq1u3';
            }
        ]);
    }

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->accessToken = $this->igdbExternalApiService->getAccessToken();
        $this->assertIsString($this->accessToken);
    }

    /**
     * @return void
     */
    public function testGetGamesSuccess(): void
    {
        $gamesResponse = $this->igdbExternalApiService->getGames();
        $this->assertNotEmpty($gamesResponse);
        $this->assertIsArray($gamesResponse);
        $this->assertCount(10, $gamesResponse);
    }

    /**
     * @return void
     */
    public function testGetGameByValidNameSuccess(): void
    {
        $name = "Waven";
        $gameResponse = $this->igdbExternalApiService->getGameByName($name);
        $this->assertNotEmpty($gameResponse);
        $this->assertIsArray($gameResponse);
        $this->assertStringContainsString($name, $gameResponse["name"]);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function testGetGameByInvalidNameFail(): void
    {
        $this->igdbExternalApiService = $this->makeEmpty(IgdbExternalApiService::class, [
            "getGameByName" => function ($name) {
                return [];
            }
        ]);
        $name = "Laravel";
        $gameResponse = $this->igdbExternalApiService->getGameByName($name);
        $this->assertEmpty($gameResponse);
    }
}

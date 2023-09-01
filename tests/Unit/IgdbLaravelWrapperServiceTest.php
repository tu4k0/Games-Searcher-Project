<?php


namespace Tests\Unit;

use App\Models\Game;
use App\Services\IgdbLaravelWrapperService;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class IgdbLaravelWrapperServiceTest extends Unit
{
    /**
     * @var \App\Services\IgdbLaravelWrapperService
     */
    protected IgdbLaravelWrapperService $igdbLaravelWrapperService;
    /**
     * @var \Tests\Support\UnitTester
     */
    protected UnitTester $tester;

    /**
     * @return void
     * @throws \Exception
     */
    protected function _inject(): void
    {
        $this->igdbLaravelWrapperService = $this->make(IgdbLaravelWrapperService::class, [
            'getGameByName' => function ($name) {
                return Game::factory()->makeOne(["name" => $name])->toArray();
            }
        ]);
    }

    /**
     * @throws \MarcReichel\IGDBLaravel\Exceptions\MissingEndpointException
     */
    public function testGetGameByExistingConsonantNameSuccess()
    {
        $name = 'Dark Souls';
        $game = $this->igdbLaravelWrapperService->getGameByName($name);
        $this->assertNotEmpty($game);
        $this->assertNotNull($game);
        $this->assertIsArray($game);
        $this->assertArrayHasKey("name", $game);
        $this->assertTrue($game["name"] === $name);
    }

    public function testGetGameByExistingSingleNameSuccess()
    {
        $name = 'Waven';
        $game = $this->igdbLaravelWrapperService->getGameByName($name);
        $this->assertNotEmpty($game);
        $this->assertNotNull($game);
        $this->assertIsArray($game);
        $this->assertArrayHasKey("name", $game);
        $this->assertContains($name, $game);
    }

    /**
     * @throws \MarcReichel\IGDBLaravel\Exceptions\MissingEndpointException
     */
    public function testGetGameByNonExistingNameFail()
    {
        $this->igdbLaravelWrapperService = $this->make(IgdbLaravelWrapperService::class, [
            'getGameByName' => function ($name) {
                return [];
            }
        ]);
        $name = 'PHP';
        $game = $this->igdbLaravelWrapperService->getGameByName($name);
        $this->assertEmpty($game);
    }
}

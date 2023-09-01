<?php


namespace Tests\Unit;

use App\Models\Game;
use App\Services\IgdbLaravelWrapperService;
use App\Transformers\GameTransformer;
use App\Transformers\GenreTransformer;
use App\Transformers\PlatformTransformer;
use Codeception\Test\Unit;
use MarcReichel\IGDBLaravel\Models\Genre as IGDBGenre;
use MarcReichel\IGDBLaravel\Models\Platform as IGDBPlatform;
use Tests\Support\UnitTester;

class TransformerTest extends Unit
{
    /**
     * @var \Tests\Support\UnitTester
     */
    protected UnitTester $tester;

    /**
     * @return void
     * @throws \Exception
     */
    public function testTransformGameResultSuccess(): void
    {
        $gameFromFactory = Game::factory()->makeOne()->toArray();
        $gameTransformer = $this->makeEmptyExcept(GameTransformer::class, 'resultTransform');
        $gameResult = $gameTransformer::resultTransform(1, 'created', $gameFromFactory);
        $this->tester->assertIsArray($gameResult);
        $this->tester->assertArrayHasKey('id', $gameResult);
        $this->tester->assertArrayHasKey('method', $gameResult);
        $this->tester->assertArrayHasKey('data', $gameResult);
    }

    /**
     * @return void
     * @throws \MarcReichel\IGDBLaravel\Exceptions\MissingEndpointException
     * @throws \Exception
     */
    public function testTransformGameSuccess(): void
    {
        $igdbLaravelWrapperService = new IgdbLaravelWrapperService();
        $igdbGame = $igdbLaravelWrapperService->getGameByName('Minecraft');
        $gameTransformer = $this->makeEmptyExcept(GameTransformer::class, 'gameTransform');
        $game = $gameTransformer::gameTransform($igdbGame);
        $this->tester->assertIsArray($game);
        $this->tester->assertArrayNotHasKey('age_ratings', $game);
        $this->tester->assertArrayNotHasKey('artworks', $game);
        $this->tester->assertArrayNotHasKey('ports', $game);
        $this->tester->assertArrayNotHasKey('screenshots', $game);
        $this->tester->assertArrayNotHasKey('tags', $game);
        $this->tester->assertArrayNotHasKey('websites', $game);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testTransformGenreSuccess(): void
    {
        $igdbGenres = IGDBGenre::all();
        $this->tester->assertNotEmpty($igdbGenres);
        $genreTransformer = $this->makeEmptyExcept(GenreTransformer::class, 'genresTransform');
        $genres = $genreTransformer::genresTransform($igdbGenres);
        $this->tester->assertNotEmpty($genres);
        $this->tester->assertIsObject($genres);
        $this->tester->assertIsIterable($genres);
        $this->tester->assertCount(23, $genres);
        $this->tester->assertNotEmpty($genres);
        $this->tester->assertNotSame($igdbGenres, $genres);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testTransformPlatformSuccess(): void
    {
        $igdbGPlatforms = IGDBPlatform::all();
        $this->tester->assertNotEmpty($igdbGPlatforms);
        $platformTransformer = $this->makeEmptyExcept(PlatformTransformer::class, 'platformsTransform');
        $platforms = $platformTransformer::platformsTransform($igdbGPlatforms);
        $this->tester->assertNotEmpty($platforms);
        $this->tester->assertIsObject($platforms);
        $this->tester->assertIsIterable($platforms);
        $this->tester->assertCount(200, $platforms);
        $this->tester->assertNotEmpty($platforms);
        $this->tester->assertNotSame($igdbGPlatforms, $platforms);
    }
}

<?php


namespace Tests\Functional;

use App\Models\Genre;
use App\Models\Platform;
use Tests\Support\FunctionalTester;

class CommandCest
{
    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function modifyGenresPlatformsSuccess(FunctionalTester $I): void
    {
        $output = $I->callArtisan('app:modify-genres-platforms');
        $I->seeRecord(Genre::class, ['name' => 'Fighting']);
        $I->seeRecord(Platform::class, ['name' => 'SteamVR']);
        $I->assertEquals('Platforms and Genres created!', $output);
    }
}

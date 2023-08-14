<?php

namespace App\Services;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Genre;
use MarcReichel\IGDBLaravel\Models\Platform;

class IgdbLaravelWrapperService
{
    public function getGames()
    {
        $gamesAmount = Game::count();
        if (Game::count() <= 500) {
            return Game::all();
        }
        return 1;
    }

    public function getGameByName($name)
    {
        return Game::search($name)->get();
    }

    public function getGenres()
    {
        return Genre::all();
    }

    public function getPlatforms()
    {
        return Platform::all();
    }
}

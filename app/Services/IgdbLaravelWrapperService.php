<?php

namespace App\Services;

use Illuminate\Support\Collection;
use MarcReichel\IGDBLaravel\Models\Game;

class IgdbLaravelWrapperService
{
    public function getGameByName(string $name): array
    {
        $igdbGames = Game::search($name)->get();
        if ($igdbGames->isNotEmpty()) {
            if ($igdbGames->count() === 1) {
                return $igdbGames->first()->toArray();
            } else {
                return $igdbGames->filter(function ($igdbGame) use ($name) {
                    return $igdbGame->name === $name;
                })->first()->toArray();
            }
        }

        return [];
    }
}

<?php

namespace App\Repositories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GameRepository
{
    public function getAllGames()
    {
        return Game::lazy(100);
    }

    public function findGameById(int $id)
    {
        return Game::findOrFail($id);
    }

    public function findGameByName(string $name)
    {
        return Game::where("name", $name)->first();
    }

    public function findAllGamesByName(string $name)
    {
        return Game::where("name", "like", "%$name%")->get()->all();
    }

    public function deleteGame(int $id)
    {
        DB::table('games')->where('id', $id)->delete();
        DB::table('game_genres')->where('game_id', $id)->delete();
        DB::table('game_platforms')->where('game_id', $id)->delete();
    }

    public function createGame(mixed $gameData)
    {
        $game = new Game;

        $game->id = gettype($gameData) === "array" ? $gameData["id"] : $gameData->first()["id"];
        $game->name = gettype($gameData) === "array" ? $gameData["name"] : $gameData->first()["name"];
        $game->rating = gettype($gameData) === "array" ? $gameData["rating"] : $gameData->first()["rating"];
        $game->summary = gettype($gameData) === "array" ? $gameData["summary"] : $gameData->first()["summary"];
        $game->first_release_date = gettype($gameData) === "array" ? $gameData["first_release_date"] : $gameData->first()["first_release_date"];
        $game->category_id = gettype($gameData) === "array" ? $gameData["category_id"] : $gameData->first()["category"] + 1;

        $game->save();

        return $game;
    }

    public function updateGame(int $id, array $gameUpdatedData)
    {
        return Game::whereId($id)->update($gameUpdatedData);
    }
}

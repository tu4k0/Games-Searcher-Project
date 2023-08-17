<?php

namespace App\Repositories;

use App\Models\Game;
use App\Services\GameService;
use App\Services\IgdbLaravelWrapperService;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class GameRepository extends BaseRepository
{
    public function model(): string
    {
        return Game::class;
    }

    public function getGames()
    {
        // to do filters
    }

    public function deleteGame(int $id): mixed
    {
        return DB::transaction(function () use ($id){
            return $this->delete($id);
        });
    }

    public function createGame(GameService $gameService, IgdbLaravelWrapperService $igdbLaravelWrapperService, array $gameData): mixed
    {
        $game = $gameService->getGameViaIGDBOrRequestBody($igdbLaravelWrapperService, $gameData);
        return DB::transaction(function () use ($game){
            return $this->create($game);
        });
    }

    public function updateGame(array $gameUpdatedData, int $id): mixed
    {
        return DB::transaction(function () use ($gameUpdatedData, $id){
            return $this->update($gameUpdatedData, $id);
        });
    }
}

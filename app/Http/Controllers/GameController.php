<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Repositories\GameRepository;
use App\Services\GameService;
use App\Services\IgdbLaravelWrapperService;
use App\Transformers\GameTransformer;

class GameController extends Controller
{
    /**
     * Display a listing of the game resource.
     */
    public function index(GameRepository $gameRepository)
    {
        // add filters
    }

    /**
     * Store a newly created game resource in storage.
     */
    public function store(GameRequest $gameRequest, GameRepository $gameRepository, GameService $gameService, IgdbLaravelWrapperService $igdbLaravelWrapperService): array
    {
        $game = $gameRepository->createGame($gameService, $igdbLaravelWrapperService, $gameRequest->toArray());

        return GameTransformer::resultTransform($game->id, "created", $game->toArray());
    }

    /**
     * Display the specified game resource.
     */
    public function show(Game $game): Game
    {
        // add relations
    }

    /**
     * Update the specified game resource in storage.
     */
    public function update(GameRequest $gameRequest, Game $game, GameRepository $gameRepository): array
    {
        $updatedGame = $gameRepository->updateGame($gameRequest->toArray(), $game->id);

        return GameTransformer::resultTransform($game->id, "updated", $updatedGame->first()->toArray());
    }

    /**
     * Remove the specified game resource from storage.
     */
    public function destroy(Game $game, GameRepository $gameRepository): array
    {
        $gameRepository->deleteGame($game->id);

        return GameTransformer::resultTransform($game->id, "deleted");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameGenre;
use App\Repositories\GameRepository;
use App\Services\IgdbLaravelWrapperService;
use App\Transformers\GameTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    protected GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * Display a listing of the game resource.
     */
    public function index()
    {
        return $this->gameRepository->getAllGames();
    }

    /**
     * Store a newly created game resource in storage.
     */
    public function store(Request $request)
    {
        $game = collect([]);
        $IGDBService = new IgdbLaravelWrapperService();
        $body = collect($request->getContent());
        if ($body) {
            $name = $request->input("name");
            $IGDBGame = $IGDBService->getGameByName($name);
            if ($IGDBGame->isNotEmpty()) {
                if ($IGDBGame->count() > 1) {
                    foreach ($IGDBGame as $gameRecord) {
                        if ($gameRecord->name === $name) {
                            $game = collect($gameRecord);
                        }
                    };
                    if ($game->isEmpty()) {
                        $game = $IGDBGame->first();
                    }
                }
                $game = GameTransformer::gameTransform($game);
            } else {
                $game = json_decode($request->getContent(), true);
            }
        }
        $createdGame = $this->gameRepository->createGame($game);

        return [
            "id" => $createdGame->id,
            'created' => true,
            'data' => $createdGame,
        ];
    }

    /**
     * Display the specified game resource.
     */
    public function show(Game $game)
    {
        return $game;
    }

    /**
     * Update the specified game resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $gameUpdatedData = [];
        $gameUpdatedData["name"] = $request->has("name") ? $request->name : $game->name;
        $gameUpdatedData["rating"] = $request->has("rating") ? $request->rating : $game->rating;
        $gameUpdatedData["summary"] = $request->has("summary") ? $request->summary : $game->summary;
        $gameUpdatedData["first_release_date"] = $request->has("first_release_date") ? $request->first_release_date : $game->first_release_date;
        $gameUpdatedData["category_id"] = $request->has("category_id") ? $request->category_id : $game->category_id;

        $this->gameRepository->updateGame($game->id, $gameUpdatedData);

        return [
            "id" => $game->id,
            'updated' => true,
            'data' => $gameUpdatedData,
        ];
    }

    /**
     * Remove the specified game resource from storage.
     */
    public function destroy(Game $game)
    {
        $this->gameRepository->deleteGame($game->id);

        return [
            "id" => $game->id,
            "deleted" => true
        ];
    }
}

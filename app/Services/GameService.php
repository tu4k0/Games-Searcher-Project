<?php

namespace App\Services;

use App\Transformers\GameTransformer;

class GameService
{
    public function getGameViaIGDBOrRequestBody(IgdbLaravelWrapperService $igdbLaravelWrapperService, array $gameAttributes): array
    {
        $igdbGame = $igdbLaravelWrapperService->getGameByName($gameAttributes["name"]);
        return !empty($igdbGame) ? GameTransformer::gameTransform($igdbGame) : $gameAttributes;
    }
}

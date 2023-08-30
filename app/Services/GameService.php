<?php

namespace App\Services;

use App\Transformers\GameTransformer;

class GameService
{
    /**
     * @throws \MarcReichel\IGDBLaravel\Exceptions\MissingEndpointException
     */
    public function getGameViaIGDBOrRequestBody(
        IgdbLaravelWrapperService $igdbLaravelWrapperService,
        array $gameAttributes
    ): array {
        $igdbGame = $igdbLaravelWrapperService->getGameByName($gameAttributes["name"]);
        return !empty($igdbGame) ? GameTransformer::gameTransform($igdbGame) : $gameAttributes;
    }
}

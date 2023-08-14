<?php

namespace App\Transformers;

use Illuminate\Support\Collection;

class GameTransformer
{
    protected static array $fillable = ['id', 'name', 'category', 'rating', 'summary', 'first_release_date'];

    public static function gameTransform(Collection $game): Collection
    {
        $transformedGame = collect();
        $transformedGame->push(collect($game)->intersectByKeys(array_flip(self::$fillable)));

        return $transformedGame;
    }
}

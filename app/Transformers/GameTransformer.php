<?php

namespace App\Transformers;

use App\Constants\GameConstant;

class GameTransformer
{
    protected static array $fillable = GameConstant::FILLABLE;

    public static function gameTransform(array $game): array
    {
        // Set category id parameter and add 1 to Game collection model to store index of category as foreign key
        // that references to primary key id on categories table.
        // Primary key id for category can not be 0.
        // Index for category in IGDB is not a primary key and starts with 0.
        $game["category_id"] = $game["category"] + 1;


        return array_intersect_key($game, array_flip(self::$fillable));
    }

    public static function resultTransform(int $id, string $method, array $data = []): array
    {
        return [
            "id" => $id,
            'method' => $method,
            'data' => $data,
        ];
    }
}

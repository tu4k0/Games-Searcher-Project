<?php

namespace App\Transformers;

use \Illuminate\Support\Collection;
use MarcReichel\IGDBLaravel\Models\Platform;

class PlatformTransformer
{
    protected static array $fillable = ['id', 'abbreviation', 'name', 'category', 'generation', 'slug'];
    protected static array $platformCategories = [
        1 => "console",
        2 => "arcade",
        3 => "platform",
        4 => "operating_system",
        5 => "portable_console",
        6 => "computer",
    ];

    public static function platformsTransform($platforms)
    {
        $transformedPlatforms = collect();
        $platforms->each(function ($platform) use ($transformedPlatforms) {
            $platform = collect($platform)->intersectByKeys(array_flip(self::$fillable));
            if ($platform->has('category')) {
                $category = self::$platformCategories[$platform->get('category')];
                $platform->put("category", $category);
            }
            $transformedPlatforms->push($platform);
        });

        return $transformedPlatforms;
    }
}

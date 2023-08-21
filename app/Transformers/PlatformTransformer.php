<?php

namespace App\Transformers;

use App\Constants\PlatformConstant;
use \Illuminate\Support\Collection;

class PlatformTransformer
{
    protected static array $fillable = PlatformConstant::FILLABLE;
    protected static array $platformCategories = PlatformConstant::PLATFORM_CATEGORIES;

    public static function platformsTransform($platforms): Collection
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

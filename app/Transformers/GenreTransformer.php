<?php

namespace App\Transformers;

use App\Constants\GenreConstant;
use Illuminate\Support\Collection;

class GenreTransformer
{
    protected static array $fillable = GenreConstant::FILLABLE;

    public static function genresTransform(Collection $genres): Collection
    {
        $transformedGenres = collect();
        $genres->each(function ($genre) use ($transformedGenres) {
            $transformedGenres->push(collect($genre)->intersectByKeys(array_flip(self::$fillable)));
        });

        return $transformedGenres;
    }
}

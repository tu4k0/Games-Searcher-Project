<?php

namespace App\Transformers;

use Illuminate\Support\Collection;
use MarcReichel\IGDBLaravel\Models\Genre;

class GenreTransformer
{
    protected static array $fillable = ['id', 'name', 'slug'];

    public static function genresTransform(Collection $genres): Collection
    {
        $transformedGenres = collect();
        $genres->each(function ($genre) use ($transformedGenres) {
            $transformedGenres->push(collect($genre)->intersectByKeys(array_flip(self::$fillable)));
        });

        return $transformedGenres;
    }
}

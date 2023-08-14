<?php

namespace App\Console\Commands;

use App\Models\Genre;
use App\Services\IgdbLaravelWrapperService;
use App\Transformers\GameTransformer;
use App\Transformers\GenreTransformer;
use App\Transformers\PlatformTransformer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use MarcReichel\IGDBLaravel\Models\Game;

class ModifyGenresPlatforms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:modify-genres-platforms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill\Update genres and platforms tables with data from igdb';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $IGDBService = new IgdbLaravelWrapperService();
        $genres = GenreTransformer::genresTransform($IGDBService->getGenres());
        $genres->each(function ($genre) {
            DB::table('genres')->updateOrInsert(["id" => $genre["id"]], [
                "id" => $genre["id"],
                "name" => $genre["name"],
                "slug" => $genre["slug"],
                "created_at" => \Carbon\Carbon::now()->toDateTimeString(),
                "updated_at" => \Carbon\Carbon::now()->toDateTimeString()
                ]);
        });
        $platforms = PlatformTransformer::platformsTransform($IGDBService->getPlatforms());
        $platforms->each(function ($platform) {
            DB::table('platforms')->updateOrInsert(["id" => $platform["id"]], [
                "id" => $platform["id"],
                "abbreviation" => $platform->has('abbreviation') ? $platform["abbreviation"] : null,
                "name" => $platform["name"],
                "category" => $platform->has('category') ? $platform["category"] : null,
                "generation" => $platform->has('generation') ? $platform["generation"] : null,
                "slug" => $platform["slug"],
                "created_at" => \Carbon\Carbon::now()->toDateTimeString(),
                "updated_at" => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        });
    }
}

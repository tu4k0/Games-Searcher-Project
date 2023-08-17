<?php

namespace App\Console\Commands;

use App\Models\Genre;
use App\Models\Platform;
use App\Transformers\GenreTransformer;
use App\Transformers\PlatformTransformer;
use Illuminate\Console\Command;
use MarcReichel\IGDBLaravel\Models\Platform as IGDBPlatform;
use MarcReichel\IGDBLaravel\Models\Genre as IGDBGenre;

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
    public function handle(): void
    {
        $this->setGenres();
        $this->setPlatforms();
    }

    private function setGenres(): void
    {
        $igdbGenres = GenreTransformer::genresTransform(IGDBGenre::all());
        $genres = Genre::all();
        $igdbGenres->each(function ($igdbGenre) use ($genres) {
            $genre = $genres->where('source_id', $igdbGenre->get('id'))->first();
            if ($genre) {
                $genre->name = $igdbGenre->get('name');
                $genre->slug = $igdbGenre->get('slug');
                $genre->push();
            } else {
                Genre::create([
                    "name" => $igdbGenre->get('name'),
                    "slug" => $igdbGenre->get('slug'),
                    "source_id" => $igdbGenre->get('id')
                ]);
            }
        });
    }

    private function setPlatforms(): void
    {
        $igdbPlatforms = PlatformTransformer::platformsTransform(IGDBPlatform::all());
        $platforms = Platform::all();
        $igdbPlatforms->each(function ($igdbPlatform) use ($platforms) {
            $platform = $platforms->where('source_id', $igdbPlatform->get('id'))->first();
            if ($platform) {
                $platform->abbreviation = $igdbPlatform->get('abbreviation');
                $platform->name = $igdbPlatform->get('name');
                $platform->category = $igdbPlatform->get('category');
                $platform->generation = $igdbPlatform->get('abbreviation');
                $platform->slug = $igdbPlatform->get('slug');
                $platform->push();
            } else {
                Platform::create([
                    "abbreviation" => $igdbPlatform->get('abbreviation'),
                    "name" => $igdbPlatform->get('name'),
                    "category" => $igdbPlatform->get('category'),
                    "generation" => $igdbPlatform->get('generation'),
                    "slug" => $igdbPlatform->get('slug'),
                    "source_id" => $igdbPlatform->get('id')
                ]);
            }
        });
    }
}

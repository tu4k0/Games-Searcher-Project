<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    const GAME_NAME = "Laravel";
    const GAME_RATING_MIN = 10;
    const GAME_RATING_MAX = 1000;
    const GAME_SUMMARY_MAX = 50;
    const GAME_CATEGORY_MIN = 1;
    const GAME_CATEGORY_MAX = 15;
    const GAME_DATE_FORMAT = 'Y-m-d';

    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            "name" => self::GAME_NAME,
            "rating" => mt_rand(self::GAME_RATING_MIN, self::GAME_RATING_MAX) / 10,
            "summary" => $this->faker->text(self::GAME_SUMMARY_MAX),
            "first_release_date" => date(self::GAME_DATE_FORMAT),
            "category_id" => random_int(self::GAME_CATEGORY_MIN, self::GAME_CATEGORY_MAX)
        ];
    }
}

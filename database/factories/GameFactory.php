<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
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
            "id" => random_int(0, 1000),
            "name" => "Laravel",
            "rating" => mt_rand(10, 1000) / 10,
            "summary" => $this->faker->text(50),
            "first_release_date" => date('Y-m-d'),
            "category_id" => random_int(1, 15)
        ];
    }
}

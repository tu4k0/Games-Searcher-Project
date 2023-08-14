<?php

namespace Tests\Feature;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GameApiTest extends TestCase
{
    public function test_clear_games_table(): void
    {
        Game::query()->delete();

        $this->assertDatabaseCount('games', 0);
    }

    public function test_games_index(): void
    {
        $game = Game::factory()->createOne([
            "name" => 'Python'
        ]);
        $response = $this->get('/api/games');
        $gamesStructure = [
            '*' => [
                'id',
                'name',
                'rating',
                'summary',
                'first_release_date',
                'category_id'
        ]];

        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $game->name])
            ->assertJsonStructure($gamesStructure);
    }

    public function test_games_show(): void
    {
        $game = Game::factory()->createOne([
            "name" => 'Java'
        ]);

        $this->json('get', "api/games/" . $game->id)
            ->assertStatus(200)
            ->assertExactJson([
                "id" => $game->id,
                "name" => $game->name,
                "rating" => $game->rating,
                "summary" => $game->summary,
                "first_release_date" => $game->first_release_date,
                "category_id" => $game->category_id
            ]);
    }

    public function test_games_store(): void
    {
        $createdGameStructure = [
            'id' => [],
            'created' => [],
            'data' => [
                'id',
                'name',
                'rating',
                'summary',
                'first_release_date',
                'category_id'
            ]];

        $game = Game::factory()->makeOne([
            "name" => 'Borik'
        ]);

        $this->json('post', 'api/games', data: $game->toArray())
            ->assertStatus(200)
            ->assertJsonStructure($createdGameStructure);

        $this->assertDatabaseHas('games', $game->toArray());
    }

    public function test_games_update(): void
    {
        $game = Game::factory()->createOne([
            "name" => 'Pascal'
        ]);

        $payload = ["summary" => "Updated"];

        $this->json('put', "api/games/" . $game->id, $payload)
            ->assertStatus(200)
            ->assertExactJson(
                [
                    "id" => $game->id,
                    'updated' => true,
                    'data' => [
                        'id' => $game->id,
                        "name" => $game->name,
                        "rating" => $game->rating,
                        "summary" => $payload["summary"],
                        "first_release_date" => $game->first_release_date,
                        "category_id" => $game->category_id
                    ]
                ]
            );
    }

    public function test_games_destroy(): void
    {
        $game = Game::factory()->createOne([
            "name" => 'Golang'
        ]);

        $this->json('delete', "api/games/$game->id")
            ->assertStatus(200);

        $this->assertDatabaseMissing('games', $game->toArray());
    }
}

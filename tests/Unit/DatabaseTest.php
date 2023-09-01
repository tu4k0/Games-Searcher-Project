<?php


namespace Tests\Unit;

use App\Models\Game;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class DatabaseTest extends Unit
{
    /**
     * @var \Tests\Support\UnitTester
     */
    protected UnitTester $tester;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->game = Game::factory()->makeOne();
    }

    /**
     * @return void
     */
    public function testInsertGameSuccess(): void
    {
        Game::create($this->game->toArray());
        $this->tester->seeInDatabase('games', $this->game->toArray());
    }

    /**
     * @return void
     */
    public function testUpdateGameSuccess(): void
    {
        $game = Game::create($this->game->toArray());
        $this->tester->seeInDatabase('games', $this->game->toArray());
        $game = Game::find($game->id);
        $game->name = fake()->name();
        $game->save();
        $this->tester->seeRecord('games', ["id" => $game->id, "name" => $game->name]);
        $this->tester->dontSeeInDatabase('games', $this->game->toArray());
    }

    /**
     * @return void
     */
    public function testDeleteGameSuccess(): void
    {
        $game = Game::create($this->game->toArray());
        $this->tester->seeInDatabase('games', $this->game->toArray());
        $game = Game::find($game->id);
        $game->delete();
        $this->tester->dontSeeInDatabase('games', ['id' => $game->id]);
    }

    /**
     * @return void
     */
    public function testSelectGameByNameSuccess(): void
    {
        Game::create($this->game->toArray());
        $this->tester->seeInDatabase('games', $this->game->toArray());
        $game = Game::where('name', $this->game->name)->first();
        $this->assertTrue($game->exists());
    }
}

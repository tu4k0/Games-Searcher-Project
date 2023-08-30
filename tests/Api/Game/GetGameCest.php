<?php


namespace Tests\Api\Game;

use App\Models\Game;
use Codeception\Util\HttpCode;
use Illuminate\Support\Facades\DB;
use Tests\Support\ApiTester;

class GetGameCest
{
    /**
     * @var \App\Models\Game|\Illuminate\Database\Eloquent\Model
     */
    private Game|\Illuminate\Database\Eloquent\Model $game;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->game = Game::factory()->createOne([
            "name" => "Minecraft"
        ]);
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function showGameByExistedIdSuccess(ApiTester $I): void
    {
        $I->amGoingTo('read game info via api using existed id in db');
        $I->seeInDatabase('games', array('id' => $this->game->id));
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendGet('games/' . $this->game->id);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'name' => 'string',
            'rating' => 'float|integer|null',
            'summary' => 'string',
            'first_release_date' => 'string|null',
            'category_id' => 'integer'
        ]);
        $I->seeResponseContains($this->game->name);
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function showGameByNonExistedIdFail(ApiTester $I): void
    {
        $I->amGoingTo('read game info via api using non existed id in db');
        $id = DB::table('games')->max('id') + 1;
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendGet('games/' . $id);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function showGameByInvalidIdFail(ApiTester $I): void
    {
        $I->amGoingTo('read game info via api using non existed id in db');
        $id = fake()->name;
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendGet('games/' . $id);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }
}

<?php


namespace Tests\Api\Game;

use App\Models\Game;
use Codeception\Util\HttpCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Tests\Support\ApiTester;

class DeleteGameCest
{
    /**
     * @var \App\Models\Game|\Illuminate\Database\Eloquent\Model
     */
    private Game|Model $game;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->game = Game::factory()->createOne();
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function deleteGameSuccess(ApiTester $I): void
    {
        $I->amGoingTo('delete game via api using delete request and existing id');
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->seeInDatabase('games', ["id" => $this->game->id]);
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendDelete('games/' . $this->game->id, ["id" => $this->game->id]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['method' => 'deleted']);
        $I->dontSeeInDatabase('games', ["id" => $this->game->id]);
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function deleteGameWithNonExistingIdFail(ApiTester $I): void
    {
        $I->amGoingTo('delete game via api using delete request and non existing id');
        $id = DB::table('games')->max('id') + 1;
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->seeInDatabase('games', ["id" => $this->game->id]);
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendDelete('games/' . $id, ["id" => $id]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeInDatabase('games', ["id" => $this->game->id]);
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function deleteGameWithInvalidIdFail(ApiTester $I): void
    {
        $I->amGoingTo('delete game via api using delete request and invalid id');
        $id = fake()->name();
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->seeInDatabase('games', ["id" => $this->game->id]);
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendDelete('games/' . $id, ["id" => $id]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeInDatabase('games', ["id" => $this->game->id]);
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function deleteGameWithInvalidRouteFail(ApiTester $I): void
    {
        $I->amGoingTo('delete game via api using delete request and invalid route');
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->seeInDatabase('games', ["id" => $this->game->id]);
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendDelete('games/', ["id" => $this->game->id]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
        $I->seeInDatabase('games', ["id" => $this->game->id]);
        $I->seeResponseContains("The DELETE method is not supported for route api/games.");
    }
}

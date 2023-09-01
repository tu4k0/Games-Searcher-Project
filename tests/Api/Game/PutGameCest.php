<?php


namespace Tests\Api\Game;

use App\Models\Game;
use Codeception\Util\HttpCode;
use Illuminate\Database\Eloquent\Model;
use Tests\Support\ApiTester;
use Illuminate\Support\Facades\DB;

class PutGameCest
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
    public function updateGameNameSuccess(ApiTester $I): void
    {
        $name = fake()->name();
        $I->amGoingTo('update game name via api using put request');
        $I->seeInDatabase('games', ["id" => $this->game->id]);
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPutAsJson('games/' . $this->game->id, [
            "name" => $name,
            "rating" => $this->game->rating,
            "summary" => $this->game->summary,
            "first_release_date" => $this->game->first_release_date,
            "category_id" => $this->game->category_id,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['method' => 'updated']);
        $I->seeInDatabase('games', ["id" => $this->game->id, "name" => $name]);
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function updateGameByNonExistingIdFail(ApiTester $I): void
    {
        $I->amGoingTo('update game summary via api using put request and non existing id');
        $id = DB::table('games')->max('id') + 1;
        $I->seeInDatabase('games', ["id" => $this->game->id]);
        $I->dontSeeInDatabase('games', ["id" => $id]);
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPutAsJson('games/' . $id, [
            "name" => $this->game->name,
            "rating" => $this->game->rating,
            "summary" => fake()->text(50),
            "first_release_date" => $this->game->first_release_date,
            "category_id" => $this->game->category_id,
        ]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContains('No query results for model');
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function updateGameByInvalidDataFail(ApiTester $I): void
    {
        $I->amGoingTo('update game summary via api using put request and invalid data');
        $I->seeInDatabase('games', ["id" => $this->game->id]);
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPutAsJson('games/' . $this->game->id, [
            "name" => 123,
            "rating" => $this->game->name,
            "summary" => $this->game->id,
            "first_release_date" => '',
            "category_id" => null,
        ]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseContains("errors");
        $I->seeResponseContainsJson([
            "message" => "The name field must be a string. (and 4 more errors)",
            "errors" => [
                "name" => [
                    "The name field must be a string."
                ],
                "rating" => [
                    "The rating field must be between 1 and 100."
                ],
                "summary" => [
                    "The summary field must be a string."
                ],
                "first_release_date" => [
                    "The first release date field is required."
                ],
                "category_id" => [
                    "The category id field is required."
                ]
            ]
        ]);
    }
}

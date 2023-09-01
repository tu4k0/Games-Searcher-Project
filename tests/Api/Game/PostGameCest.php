<?php


namespace Tests\Api\Game;

use Codeception\Util\HttpCode;
use Tests\Support\ApiTester;
use \Codeception\Example;

class PostGameCest
{
    /**
     * @dataProvider createGameSuccessProvider
     *
     * @param \Tests\Support\ApiTester $I
     * @param \Codeception\Example $gameValidDataSet
     * @return void
     */
    public function createGameSuccess(
        ApiTester $I,
        Example $gameValidDataSet
    ): void {
        $I->amGoingTo('create game via api using post request and valid data');
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $gameResponse = $I->sendPostAsJson('games/', [
            "name" => $gameValidDataSet["name"],
            "rating" => $gameValidDataSet["rating"],
            "summary" => $gameValidDataSet["summary"],
            "first_release_date" => $gameValidDataSet["first_release_date"],
            "category_id" => $gameValidDataSet["category_id"],
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['method' => 'created']);
        $I->seeInDatabase('games', ["id" => $gameResponse["id"]]);
    }

    /**
     * @dataProvider createGameEmptyParamsFailProvider
     *
     * @param \Tests\Support\ApiTester $I
     * @param \Codeception\Example $gameEmptyParam
     * @return void
     */
    public function createGameWithEmptyParamsFail(ApiTester $I, Example $gameEmptyParam): void
    {
        $I->amGoingTo('create game with empty name via api using post request');
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $gameResponse = $I->sendPostAsJson('games/', [
            "name" => $gameEmptyParam["name"],
            "rating" => $gameEmptyParam["rating"],
            "summary" => $gameEmptyParam["summary"],
            "first_release_date" => $gameEmptyParam["first_release_date"],
            "category_id" => $gameEmptyParam["category_id"],
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->dontSeeInDatabase('games', collect($gameEmptyParam)->toArray());
    }

    /**
     * @dataProvider createGameViaIgdbApiSuccessProvider
     *
     * @param \Tests\Support\ApiTester $I
     * @param \Codeception\Example $gameIGDBSet
     * @return void
     */
    public function createGameViaIgdbExternalApiSuccess(ApiTester $I, Example $gameIGDBSet): void
    {
        $I->amGoingTo('create game via igdb api using post request and source id');
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $gameResponse = $I->sendPostAsJson('games/', [
            "name" => $gameIGDBSet["name"],
            "rating" => $gameIGDBSet["rating"],
            "summary" => $gameIGDBSet["summary"],
            "first_release_date" => $gameIGDBSet["first_release_date"],
            "category_id" => $gameIGDBSet["category_id"],
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->dontSeeInDatabase('games', collect($gameIGDBSet)->toArray());
        $I->seeInDatabase('games', $gameResponse["data"]);
        $I->dontSeeResponseContainsJson(["data" => collect($gameIGDBSet)->toArray()]);
    }

    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function createGameWithOnlyOneParamFail(ApiTester $I): void
    {
        $I->amGoingTo('create game with only name field via api using post request');
        $I->amHttpAuthenticated('user', 'qwerty123');
        $name = 'name';
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->sendPostAsJson('games/', [
            "name" => $name
        ]);
        $I->seeResponseCodeIsClientError();
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->dontSeeInDatabase('games', ["name" => $name]);
        $I->seeResponseContainsJson([
            "errors" =>  [
                "summary" => [
                    "The summary field is required."
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

    /**
     * @return array[]
     */
    protected function createGameSuccessProvider(): array
    {
        return [
           "gameValidDataSet1" => [
            "name" => 'Artisan',
            "rating" => 20.5,
            "summary" => "dssdadads",
            "first_release_date" => '22.12.2012',
            "category_id" => 2
            ],
            "gameValidDataSet2" => [
                "name" => 'Swasaddaser',
                "rating" => 11,
                "summary" => "asdew",
                "first_release_date" => '23.12.2012',
                "category_id" => 1
            ]
        ];
    }

    /**
     * @return array[]
     */
    protected function createGameEmptyParamsFailProvider(): array
    {
        return [
            "gameEmptyParamName" => [
                "name" => '',
                "rating" => 20.5,
                "summary" => "dssdadads",
                "first_release_date" => '22.12.2012',
                "category_id" => 2
            ],
            "gameEmptyParamRating" => [
                "name" => 'Artisan',
                "rating" => null,
                "summary" => "dssdadads",
                "first_release_date" => '22.12.2012',
                "category_id" => 2
            ],
            "gameEmptyParamSummary" => [
                "name" => 'Artisan',
                "rating" => 20.5,
                "summary" => "",
                "first_release_date" => '22.12.2012',
                "category_id" => 2
            ],
            "gameEmptyParamFirstReleaseDate" => [
                "name" => 'Artisan',
                "rating" => 20.5,
                "summary" => "dssdadads",
                "first_release_date" => '',
                "category_id" => 2
            ],
            "gameEmptyParamCategoryId" => [
                "name" => 'Artisan',
                "rating" => 20.5,
                "summary" => "dssdadads",
                "first_release_date" => '22.12.2012',
                "category_id" => null
            ],
        ];
    }

    /**
     * @return array[]
     */
    protected function createGameViaIgdbApiSuccessProvider(): array
    {
        return [
            "gameIGDBSet1" => [
                "name" => 'Minecraft',
                "rating" => 1,
                "summary" => "text",
                "first_release_date" => '22.12.2012',
                "category_id" => 1
            ],
            "gameIGDBSet2" => [
                "name" => 'Dark Souls',
                "rating" => 1,
                "summary" => "text",
                "first_release_date" => '22.12.2012',
                "category_id" => 1
            ]
        ];
    }
}

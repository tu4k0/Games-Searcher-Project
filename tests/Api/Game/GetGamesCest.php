<?php


namespace Tests\Api\Game;

use Codeception\Util\HttpCode;
use Tests\Support\ApiTester;

class GetGamesCest
{
    /**
     * @param \Tests\Support\ApiTester $I
     * @return void
     */
    public function showGamesViaApi(ApiTester $I): void
    {
        $I->amGoingTo('read game info via api using existed id in db');
        $I->amHttpAuthenticated('user', 'qwerty123');
        $I->sendGet('games/');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}

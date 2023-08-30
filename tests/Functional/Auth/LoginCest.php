<?php


namespace Tests\Functional\Auth;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Tests\Support\FunctionalTester;

class LoginCest
{
    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function _before(FunctionalTester $I): void
    {
        $I->amOnPage("/");
        $I->click("Log in");
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function loginSuccess(FunctionalTester $I): void
    {
        $I->amGoingTo('submit login form with valid data');
        $password = 'asdasdf2512';
        $user = User::factory()->createOne([
            "password" => Hash::make($password)
        ]);
        $I->see('Email');
        $I->see('Password');
        $I->fillField('email', $user->email);
        // Hash value of qwerty123 is set as password for every user in UserFactory
        $I->fillField('password', $password);
        $I->click('Login');
        $I->seeCurrentUrlEquals('/');
        $I->dontSee('Log in');
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function loginWithInvalidEmailFail(FunctionalTester $I): void
    {
        $I->amGoingTo('submit login form with invalid email');
        $I->see('Email');
        $I->see('Password');
        $I->fillField('email', "example");
        $I->fillField('password', 'qwerty123');
        $I->click('Login');
        $I->expect('The email field must be a valid email address.');
        $I->see('The email field must be a valid email address');
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function loginWithInvalidPasswordFail(FunctionalTester $I): void
    {
        $I->amGoingTo('submit login form with invalid password');
        $password = 'asdasdf2512';
        $user = User::factory()->createOne();
        $I->see('Email');
        $I->see('Password');
        $I->fillField('email', $user->email);
        $I->fillField('password', $password);
        $I->click('Login');
        $I->expect('The user data is invalid.');
        $I->seeCurrentUrlEquals('/login');
        $I->see('The user data is invalid.');
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function loginWithEmptyDataFail(FunctionalTester $I): void
    {
        $I->amGoingTo('submit login form with empty email and password');
        $I->see('Email');
        $I->see('Password');
        $I->fillField('email', UserFactory::makeEmail());
        $I->fillField('password', UserFactory::makePassword());
        $I->click('Login');
        $I->dontSeeCurrentUrlEquals('/');
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function loginViaGoogleAuthSuccess(FunctionalTester $I): void
    {
        $I->amGoingTo('login via Google Auth');
        $I->see('Email');
        $I->see('Password');
        $I->click('#google_auth');
    }
}

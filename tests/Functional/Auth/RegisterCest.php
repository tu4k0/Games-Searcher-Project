<?php


namespace Tests\Functional\Auth;

use Database\Factories\UserFactory;
use Tests\Support\FunctionalTester;

class RegisterCest
{
    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function _before(FunctionalTester $I): void
    {
        $I->amOnPage("/");
        $I->click("Register");
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function registerSuccess(FunctionalTester $I): void
    {
        $I->amGoingTo('submit register form with valid data');
        $password = UserFactory::makePassword();
        $I->see('Register');
        $I->submitForm('#register_user', array(
            'login' => UserFactory::makeLogin(),
            'email' => UserFactory::makeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ));
        $I->see('Laravel');
        $I->dontSee('Login');
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function registerWithEmptyDataFail(FunctionalTester $I): void
    {
        $I->amGoingTo('submit login form with empty data');
        $I->see('Register');
        $I->submitForm('#register_user', array(
            'login' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ));
        $I->see('The login field is required.');
        $I->see('The email field is required.');
        $I->see('The password field is required.');
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function registerWithInvalidLoginFail(FunctionalTester $I): void
    {
        $login = 'kyrylo';
        $password = UserFactory::makePassword();
        $I->amGoingTo('submit login form with invalid login that is less than 8 symbols');
        $I->see('Register');
        $I->submitForm('#register_user', array(
            'login' => $login,
            'email' => UserFactory::makeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ));
        $I->expect('The login field must be at least 8 characters.');
        $I->see('The login field must be at least 8 characters.');
    }

    /**
     * @param \Tests\Support\FunctionalTester $I
     * @return void
     */
    public function registerWithInvalidPasswordFail(FunctionalTester $I): void
    {
        $I->amGoingTo('submit login form with invalid password confirmation');
        $I->see('Register');
        $I->submitForm('#register_user', array(
            'login' => UserFactory::makeLogin(),
            'email' => UserFactory::makeEmail(),
            'password' => UserFactory::makePassword(),
            'password_confirmation' => UserFactory::makePassword(),
        ));
        $I->expect('The password field confirmation does not match.');
        $I->see('The password field confirmation does not match.');
    }
}

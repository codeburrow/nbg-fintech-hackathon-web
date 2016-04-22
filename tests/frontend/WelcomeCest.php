<?php


class WelcomeCest
{
    public function _before(FrontendTester $I)
    {
    }

    public function _after(FrontendTester $I)
    {
    }

    // tests
    public function tryToTest(FrontendTester $I)
    {
        $I->amOnPage('/');
        $I->seeCurrentUrlEquals('/');
        $I->see('Show Marketing Page.');
    }
}

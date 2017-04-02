<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modelizer\Selenium\SeleniumTestCase;

class LoginTest extends SeleniumTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAuthenticationSuccess()
    {
        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login')
             ->type('test+normal@example.ex', '#email')
             ->type('password123', '#password')
             ->click('#login-button')
             ->see('User: Normal User');
    }
}

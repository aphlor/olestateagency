<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modelizer\Selenium\SeleniumTestCase;

class LoginTest extends SeleniumTestCase
{
    /**
     * Test the login form
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

    /**
     * Test the authentication failure handling
     *
     * @return void
     */
    public function testAuthenticationFailure()
    {
        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login')
             ->type('test+normal@example.ex', '#email')
             ->type('123password', '#password')
             ->click('#login-button')
             ->see('These credentials do not match our records');
    }

    /**
     * Test the password reset
     *
     * @return void
     */
    public function testPasswordReset()
    {
        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login')
             ->click('Forgot Your Password?')
             ->seePageIs('/password/reset')
             ->type('test+normal@example.ex', '#email')
             ->press('Send Password Reset Link')
             ->see('We have e-mailed your password reset link!');
    }

    /**
     * Test account registration
     *
     * @return void
     */
    public function testRegister()
    {
        $id = uniqid();

        $this->visit('/')
             ->click('Register')
             ->seePageIs('/register')
             ->type('Testy McTestFace ' . $id, '#name')
             ->type('test+' . $id . '@example.ex', '#email')
             ->type('password123', '#password')
             ->type('password123', '#password-confirm')
             ->press('Register')
             ->see('User: Testy McTestFace ' . $id);
    }
}

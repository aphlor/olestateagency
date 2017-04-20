<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modelizer\Selenium\SeleniumTestCase;

class MessageTest extends SeleniumTestCase
{
    /**
     * Test property view
     *
     * @return void
     */
    public function testSendMessage()
    {
        $this->visit('/contact/message')
             ->type('foobarbaz', '#name')
             ->type('test+normal@example.ex', '#email')
             ->type('This is a test message', '#message')
             ->click('#btn-send')
             ->seePageIs('/contact/sendmessage')
             ->see('Your message has been sent');
    }
}

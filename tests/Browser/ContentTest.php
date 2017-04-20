<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modelizer\Selenium\SeleniumTestCase;

class ContentTest extends SeleniumTestCase
{
    private static $lipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut odio pharetra, euismod purus a, auctor ante. Vivamus et accumsan dolor. Sed feugiat, augue vitae elementum suscipit, ante lectus scelerisque leo, vitae rutrum purus quam a est. Nulla sodales, tortor in tincidunt tempor, lacus nisl tristique felis, a lacinia ipsum eros non dolor. Cras varius eros quis neque cursus pulvinar. Vivamus lobortis risus rhoncus, interdum magna et, mollis nisi. Donec eros orci, vulputate eget erat quis, pharetra dictum turpis. Mauris feugiat posuere tempus.';

    /**
     * Test property view
     *
     * @return void
     */
    public function testMakeContentPage()
    {
        $pageTitle = 'content' . uniqid();

        $this->visit('/')
             ->click('Login')
             ->type('test+superuser@example.ex', '#email')
             ->type('password123', '#password')
             ->click('#login-button')
             ->visit('/content/create')
             ->type('test page content ' . uniqid(), '#title')
             ->type($pageTitle, '#pagePath')
             ->click('#save')
             ->see('/content/view/' . $pageTitle);
    }
}

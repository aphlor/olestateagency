<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modelizer\Selenium\SeleniumTestCase;

class PropertyTest extends SeleniumTestCase
{
    /**
     * Test property view
     *
     * @return void
     */
    public function testViewProperty()
    {
        $this->visit('/property/1')
             ->see('This is a delightful Victorian property');
    }

    /**
     * Check we can't see a "Save" button whilst not logged in
     *
     * @return void
     */
    public function testCannotSaveProperty()
    {
        $this->visit('/property/1')
             ->see('This is a delightful Victorian property');
        $this->notSee('Save to');
    }

    /**
     * Check we can see a "Save" button whilst logged in
     *
     * @return void
     */
    public function testCanSaveProperty()
    {
        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login')
             ->type('test+normal@example.ex', '#email')
             ->type('password123', '#password')
             ->click('#login-button');
        $this->visit('/property/1')
             ->see('This is a delightful Victorian property');
        $this->see('Save to');
        $this->press('#btn-save');
        $this->visit('/properties/saved')
             ->see('Victorian townhouse');
    }

    /**
     * Check we can remove saved properties
     *
     * @return void
     */
    public function testCanUnsaveProperty()
    {
        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login')
             ->type('test+normal@example.ex', '#email')
             ->type('password123', '#password')
             ->click('#login-button');
        $this->visit('/property/1')
             ->see('This is a delightful Victorian property')
             ->see('Remove from')
             ->click('#btn-remove');
        $this->visit('/properties/saved')
             ->notSee('Victorian townhouse');
    }
}

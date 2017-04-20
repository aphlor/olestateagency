<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modelizer\Selenium\SeleniumTestCase;

class PropertyListTest extends SeleniumTestCase
{
    /**
     * Test property list defaults
     *
     * @return void
     */
    public function testUnfilteredProperties()
    {
        $this->visit('/properties')
             ->see('Victorian townhouse')
             ->see('Five bedroom mill conversion')
             ->see('Shack in the desert');
    }

    /**
     * Test filter by minimum price
     *
     * @return void
     */
    public function testFilterMinimumPrice()
    {
        $this->visit('/properties')
             ->type('4500000', '#minPrice')
             ->press('Update results')
             ->see('Victorian townhouse');
        $this->notSee('Five bedroom mill conversion');
        $this->notSee('Shack in the desert');
    }

    /**
     * Test filter by maximum price
     *
     * @return void
     */
    public function testFilterMaximumPrice()
    {
        $this->visit('/properties')
             ->type('450', '#maxPrice')
             ->press('Update results')
             ->see('Shack in the desert');
        $this->notSee('Five bedroom mill conversion');
        $this->notSee('Victorian townhouse');
    }

    /**
     * Test filter by bedrooms
     *
     * @return void
     */
    public function testFilterBedrooms()
    {
        $this->visit('/properties')
             ->select('#bedrooms', 1)
             ->press('Update results')
             ->see('Shack in the desert');
        $this->notSee('Five bedroom mill conversion');
        $this->notSee('Victorian townhouse');
    }

    /**
     * Test filter by keywords
     *
     * @return void
     */
    public function testFilterKeywords()
    {
        $this->visit('/properties')
             ->type('the', '#keywords')
             ->press('Update results')
             ->see('Shack in the desert')
             ->see('Victorian townhouse');
        $this->notSee('Five bedroom mill conversion');
    }

    /**
     * Test filter with save search
     *
     * @return void
     */
    public function testFilterSave()
    {
        $searchName = 'search' . uniqid();

        $this->visit('/')
             ->click('Login')
             ->seePageIs('/login')
             ->type('test+normal@example.ex', '#email')
             ->type('password123', '#password')
             ->click('#login-button');
        $this->visit('/properties')
             ->type('the', '#keywords')
             ->press('Update results')
             ->see('Shack in the desert')
             ->see('Victorian townhouse');
        $this->type($searchName, '#searchName')
             ->press('Save search');
        $this->visit('/properties/searches')
             ->see($searchName)
             ->press('#search-' . md5($searchName));
        $this->see('Shack in the desert')
             ->see('Victorian townhouse');
        $this->notSee('Five bedroom mill conversion');
    }
}

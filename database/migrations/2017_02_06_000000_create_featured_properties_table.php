<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedPropertiesTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')
                  ->unsigned();                           // primary key
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties');                           // user who caused the action
            $table->smallInteger('display_order', false, true); // sorting order (0 = highlight)
        });
    }

    /**
     * Reverse the migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featured_properties');
    }
}

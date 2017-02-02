<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyImagesTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')
                  ->unsigned();                           // primary key
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties');                           // user who caused the action
            $table->smallInteger('display_order', false, true); // sorting order (0 = highlight)
            $table->string('image_filename');                   // filename in property image path
            $table->text('description');                        // descriptive text
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_images');
    }
}

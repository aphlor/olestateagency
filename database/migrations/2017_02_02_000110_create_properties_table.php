<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');           // primary key
            $table->text('title');              // property headline title
            // $table->text('subtitle')
            //       ->nullable();                 // property subtitle
            $table->text('description')
                  ->nullable();                 // long-format description for detail view
            $table->text('short_description')
                  ->nullable();                 // short description for search results view
            $table->tinyInteger('bedrooms')
                  ->unsigned()
                  ->nullable();
            $table->string('address_line_1');   // address
            $table->string('address_line_2')
                  ->nullable();
            $table->string('town');
            $table->string('county')
                  ->nullable();
            $table->string('postcode')
                  ->nullable();
            $table->float('price', 10, 2);      // price; 10 digits total, 2 of which are pence
            $table->integer('price_format_id')
                  ->unsigned();
            $table->foreign('price_format_id')
                  ->references('id')
                  ->on('price_formats');
            $table->integer('property_status_id')
                  ->unsigned();
            $table->foreign('property_status_id')
                  ->references('id')
                  ->on('property_statuses');
            $table->timestamps();
            $table->softDeletes();              // handle "soft" deletion
        });

        DB::statement('
            ALTER TABLE properties
                    ADD FULLTEXT key_search (title,
                                             description,
                                             short_description,
                                             address_line_1,
                                             address_line_2,
                                             town,
                                             county,
                                             postcode)
        ');
    }

    /**
     * Reverse the migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}

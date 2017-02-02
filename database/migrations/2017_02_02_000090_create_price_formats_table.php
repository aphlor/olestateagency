<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceFormatsTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display_text'); // short descriptive text
            $table->text('description');    // more descriptive explanation of price format
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_formats');
    }
}

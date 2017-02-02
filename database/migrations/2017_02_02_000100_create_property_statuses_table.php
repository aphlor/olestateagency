<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')
                  ->unique();
            $table->tinyInteger('marketable')
                  ->unsigned()
                  ->default(0);
        });

        DB::table('property_statuses')->insert([
            'status' => 'Available',
            'marketable' => 1,
        ]);

        DB::table('property_statuses')->insert([
            'status' => 'Under offer',
            'marketable' => 1,
        ]);

        DB::table('property_statuses')->insert([
            'status' => 'Offer accepted',
            'marketable' => 1,
        ]);

        DB::table('property_statuses')->insert([
            'status' => 'Sold (subject to contract)',
            'marketable' => 1,
        ]);

        DB::table('property_statuses')->insert([
            'status' => 'Sold',
            'marketable' => 0,
        ]);

        DB::table('property_statuses')->insert([
            'status' => 'Withdrawn',
            'marketable' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_statuses');
    }
}

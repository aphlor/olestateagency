<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTrailTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_trail', function (Blueprint $table) {
            $table->increments('id');       // primary key
            $table->string('table');        // name of the table this affects
            $table->integer('user_id')
                  ->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');            // user who caused the action
            $table->text('action');         // description of the action invoked
        });
    }

    /**
     * Reverse the migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_trail');
    }
}

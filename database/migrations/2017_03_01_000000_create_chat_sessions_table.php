<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatSessionsTable extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('initiating_user_id')
                  ->unsigned()
                  ->nullable();
            $table->foreign('initiating_user_id')
                  ->references('id')
                  ->on('users');
            $table->integer('accepting_user_id')
                  ->unsigned()
                  ->nullable();
            $table->foreign('accepting_user_id')
                  ->references('id')
                  ->on('users');
            $table->text('subject');
            $table->tinyInteger('completed')
                  ->unsigned()
                  ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_sessions');
    }
}

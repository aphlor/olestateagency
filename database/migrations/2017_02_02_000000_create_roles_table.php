<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name')
                  ->unique();
            $table->tinyInteger('manage_accounts')
                  ->unsigned()
                  ->default(0);
            $table->tinyInteger('manage_properties')
                  ->unsigned()
                  ->default(0);
        });

        DB::table('roles')->insert([
            'role_name' => 'Superuser',
            'manage_accounts' => 1,
            'manage_properties' => 1,
        ]);

        DB::table('roles')->insert([
            'role_name' => 'Staff agent',
            'manage_accounts' => 0,
            'manage_properties' => 1,
        ]);

        DB::table('roles')->insert([
            'role_name' => 'Normal user',
            'manage_accounts' => 0,
            'manage_properties' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}

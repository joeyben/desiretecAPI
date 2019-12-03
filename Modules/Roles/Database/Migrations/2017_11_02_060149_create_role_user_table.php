<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('role_user_user_id_foreign');
            $table->integer('role_id')->unsigned()->index('role_user_role_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if ('testing' !== app()->environment()) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('role_user');

        if ('testing' !== app()->environment()) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

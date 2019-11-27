<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned()->index('permission_role_permission_id_foreign');
            $table->integer('role_id')->unsigned()->index('permission_role_role_id_foreign');
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

        Schema::dropIfExists('permission_role');

        if ('testing' !== app()->environment()) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

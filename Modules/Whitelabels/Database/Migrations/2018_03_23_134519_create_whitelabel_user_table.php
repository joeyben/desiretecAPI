<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWhitelabelUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('whitelabel_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('whitelabel_user_user_id_foreign');
            $table->integer('whitelabel_id')->unsigned()->index('whitelabel_user_whitelabel_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('whitelabel_user');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

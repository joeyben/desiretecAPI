<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhitelabelUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('whitelabel_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('whitelabel_user_user_id_foreign');
            $table->integer('whitelabel_id')->unsigned()->index('whitelabel_user_whitelabel_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whitelabel_user');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageWhitelabelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_whitelabel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned()->index('language_whitelabel_language_id_foreign');
            $table->integer('whitelabel_id')->unsigned()->index('language_whitelabel_whitelabel_id_foreign');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_whitelabel');
    }
}

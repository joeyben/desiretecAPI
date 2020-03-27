<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhitelabelHostsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('whitelabel_hosts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('whitelabel_id')->unsigned()->index();
            $table->string('host', 255);
            $table->timestamps();
        });

        Schema::table('whitelabel_hosts', function (Blueprint $table) {
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('whitelabel_hosts');
    }
}

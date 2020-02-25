<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhitelabelHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whitelabel_hosts');
    }
}

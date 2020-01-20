<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayersWhitelabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layers_whitelabels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('whitelabel_id');
            $table->unsignedInteger('layer_id');
            $table->string('image', 255);
            $table->string('layer_url', 255);
            $table->string('title', 255);
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layers_whitelabels');
    }
}

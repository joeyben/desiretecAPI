<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LayerWhitelabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layer_whitelabel', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('whitelabel_id');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
            $table->unsignedBigInteger('layer_id');
            $table->foreign('layer_id')->references('id')->on('layers')->onDelete('cascade');
            $table->string('image', 255);
            $table->string('headline', 100);
            $table->string('subheadline', 100);
            $table->string('layer_url', 255);
            $table->string('headline_success', 100);
            $table->text('subheadline_success');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

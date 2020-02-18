<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('path', 255);
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('layer_whitelabel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('whitelabel_id')->unsigned()->index();
            $table->integer('layer_id')->unsigned()->index();
            $table->string('image', 255);
            $table->string('headline', 100);
            $table->string('subheadline', 100);
            $table->string('layer_url', 255);
            $table->string('headline_success', 100);
            $table->text('subheadline_success');
        });

        Schema::table('layer_whitelabel', function (Blueprint $table) {
            $table->foreign('layer_id')->references('id')->on('layers')->onDelete('cascade');
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
        Schema::dropIfExists('whitelabels');
    }
}

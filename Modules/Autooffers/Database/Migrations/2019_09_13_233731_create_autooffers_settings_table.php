<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutooffersSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('autooffers_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('display_offer');
            $table->unsignedSmallInteger('recommendation');
            $table->decimal('rating', 3, 2);
            $table->enum('price', ['asc', 'desc'])->default('asc');
            $table->unsignedSmallInteger('price_loop')->default(20);
            $table->unsignedSmallInteger('hotel_loop')->default(3);


            $table->boolean('status')->default();
            $table->integer('user_id')->unsigned();
            $table->integer('whitelabel_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('autooffers_settings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('autooffers_settings');
    }
}

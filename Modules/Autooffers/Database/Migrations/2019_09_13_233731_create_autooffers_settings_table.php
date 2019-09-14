<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutooffersSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autooffers_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('display_offer');
            $table->unsignedSmallInteger('recommendation');
            $table->decimal('rating', 3,2);

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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autooffers_settings');
    }
}

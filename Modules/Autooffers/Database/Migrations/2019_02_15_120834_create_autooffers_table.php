<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAutooffersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('autooffers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('type');
            $table->integer('personPrice')->unsigned();
            $table->integer('totalPrice')->unsigned();
            $table->string('from');
            $table->string('to');
            $table->string('tourOperator_code');
            $table->string('tourOperator_name');
            $table->string('hotel_code');
            $table->string('hotel_name');
            $table->string('hotel_location_name');
            $table->float('hotel_location_lng', 15, 8);
            $table->float('hotel_location_lat', 15, 8);
            $table->string('hotel_location_region_code');
            $table->string('hotel_location_region_name');
            $table->string('airport_code');
            $table->string('airport_name');
            $table->text('data');
            $table->text('hotel_data');
            $table->boolean('status')->default(true);
            $table->integer('wish_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('autooffers', function (Blueprint $table) {
            $table->foreign('wish_id')->references('id')->on('wishes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('autooffers');

        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

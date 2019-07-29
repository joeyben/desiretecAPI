<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovasolAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('novasol_area', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('novasol_country_id')->unsigned();
            $table->integer('novasol_area_code')->unsigned();
            $table->timestamps();
            $table->foreign('novasol_country_id')->references('novasol_code')->on('novasol_country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

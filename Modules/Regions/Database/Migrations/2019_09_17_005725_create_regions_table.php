<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('Regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('region_code', 10);
            $table->string('region_name');
            $table->string('country_code');
            $table->smallInteger('type');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('Regions');
    }
}

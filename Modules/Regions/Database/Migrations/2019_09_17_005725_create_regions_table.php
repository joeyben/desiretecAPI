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
            $table->string('regionCode', 10);
            $table->string('regionName');
            $table->string('countryCode');
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

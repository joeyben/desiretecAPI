<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltercategoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('filter_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('shown');
            $table->smallInteger('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('filter_category');
    }
}

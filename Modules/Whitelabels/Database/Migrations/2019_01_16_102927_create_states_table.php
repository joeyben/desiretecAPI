<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('step')->default(0);

            $table->timestamps();
        });

        if (Schema::hasTable('whitelabels')) {
            Schema::table('whitelabels', function (Blueprint $table) {
                $table->integer('state_id')->after('bg_image')->nullable()->unsigned()->index();
                $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}

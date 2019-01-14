<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhitelabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whitelabels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->string('display_name', 191);
            $table->boolean('status')->default(true);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('distribution_id')->unsigned()->nullable();
            $table->string('bg_image', 191);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('whitelabels', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('distribution_id')->references('id')->on('distributions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('whitelabels');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

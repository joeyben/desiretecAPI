<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer_id')->nullable()->unsigned();
            $table->string('file', 255);
            $table->timestamps();
        });

        Schema::table('offer_files', function (Blueprint $table) {
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('offer_files');

        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToWhitelabelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->string('email', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}

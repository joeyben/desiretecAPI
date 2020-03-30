<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampToWhitelabelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('layer_whitelabel', function (Blueprint $table) {
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('layer_whitelabel', function (Blueprint $table) {
        });
    }
}

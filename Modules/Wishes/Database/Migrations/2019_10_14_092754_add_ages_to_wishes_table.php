<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgesToWishesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->string('ages', 21)->nullable();
            $table->string('direkt_flug', 120)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}

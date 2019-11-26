<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraParamsToWishesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->text('extra_params')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBgImageWhitelabelsTable extends Migration
{
    public function up()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->string('bg_image', 191);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->dropColumn('bg_image');
        });
    }
}

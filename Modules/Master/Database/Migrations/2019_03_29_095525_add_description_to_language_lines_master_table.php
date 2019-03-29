<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToLanguageLinesMasterTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('language_lines_master', function (Blueprint $table) {
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('language_lines_master', function (Blueprint $table) {
            $table->dropColumn('description')->nullable();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguageLinesTrendtoursTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('language_lines_trendtours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale');
            $table->string('description');
            $table->string('group');
            $table->index('group');
            $table->string('key');
            $table->text('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('language_lines_trendtours');
    }
}

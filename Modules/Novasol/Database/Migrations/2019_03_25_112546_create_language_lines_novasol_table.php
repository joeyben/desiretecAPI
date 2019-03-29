<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguageLinesNovasolTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('language_lines_novasol', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale');
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
        Schema::drop('language_lines_novasol');
    }
}

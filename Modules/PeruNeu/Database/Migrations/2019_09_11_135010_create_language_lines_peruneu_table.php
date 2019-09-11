<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateLanguageLinesPeruNeuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('language_lines_peruneu')) {
                Schema::create('language_lines_peruneu', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('locale');
                    $table->string('description')->nullable();
                    $table->string('group');
                    $table->index('group');
                    $table->string('key');
                    $table->text('text');
                    $table->timestamps();
                });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         if (Schema::hasTable('language_lines_peruneu')) {
             Schema::drop('language_lines_peruneu');
         }
    }
}

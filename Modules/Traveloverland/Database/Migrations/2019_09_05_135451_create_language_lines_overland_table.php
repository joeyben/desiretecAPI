<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageLinesOverlandTable extends Migration
{
    /**
     * Run the migrations.     */
    public function up()
    {
        if (!Schema::hasTable('language_lines_overland')) {
            Schema::create('language_lines_overland', function (Blueprint $table) {
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
     */
    public function down()
    {
        if (Schema::hasTable('language_lines_overland')) {
            Schema::drop('language_lines_overland');
        }
    }
}
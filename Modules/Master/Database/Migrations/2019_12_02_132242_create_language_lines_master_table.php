<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageLinesMasterTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('language_lines_master')) {
            Schema::create('language_lines_master', function (Blueprint $table) {
                $table->increments('id');
                $table->string('locale');
                $table->string('group');
                $table->index('group');
                $table->string('key');
                $table->text('text');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('language_lines_master') && !Schema::hasColumn('language_lines_master', 'description')) {
            Schema::table('language_lines_master', function (Blueprint $table) {
                $table->string('description')->after('group')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasTable('language_lines_master')) {
            Schema::drop('language_lines_master');
        }
    }
}

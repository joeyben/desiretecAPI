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
        if (Schema::hasTable('language_lines_master') && Schema::hasColumn('language_lines_master', 'description')) {
            Schema::table('language_lines_master', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWhitelabelIdToLanguageLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('language_lines') && !Schema::hasColumn('language_lines', 'whitelabel_id')) {
            Schema::table('language_lines', function (Blueprint $table) {
                $table->integer('whitelabel_id')->nullable()->unsigned();
                $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
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
        Schema::table('language_lines', function (Blueprint $table) {

        });
    }
}

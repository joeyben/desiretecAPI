<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVersionToWishesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('wishes') && !Schema::hasColumn('wishes', 'version')) {
            Schema::table('wishes', function (Blueprint $table) {
                $table->string('version')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->dropColumn('version');
        });
    }
}

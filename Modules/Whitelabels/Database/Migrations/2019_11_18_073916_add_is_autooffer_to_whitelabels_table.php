<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAutoofferToWhitelabelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('whitelabels') && !Schema::hasColumn('whitelabels', 'is_autooffer')) {
            Schema::table('whitelabels', function (Blueprint $table) {
                $table->smallInteger('is_autooffer')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->dropColumn('is_autooffer');
        });
    }
}

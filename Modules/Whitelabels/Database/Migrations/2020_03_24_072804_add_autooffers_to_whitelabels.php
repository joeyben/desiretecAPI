<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutooffersToWhitelabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('whitelabels') && !Schema::hasColumn('whitelabels', 'traffics')) {
            Schema::table('whitelabels', function (Blueprint $table) {
                $table->tinyInteger('traffics')->default(0);
                $table->tinyInteger('tt')->default(0);
                $table->tinyInteger('peakwork')->default(0);
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
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->dropColumn('traffics');
            $table->dropColumn('tt');
            $table->dropColumn('peakwork');
        });
    }
}

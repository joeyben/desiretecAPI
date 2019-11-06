<?php

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLayerToWhitelabels extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('whitelabels') && !Schema::hasColumn('whitelabels', 'layer')) {
            Schema::table('whitelabels', function (Blueprint $table) {
                $table->enum('layer', [Flag::PACKAGE, Flag::FLIGHT, Flag::CRUISE])->default(Flag::PACKAGE);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->dropColumn('layer');
        });
    }
}

<?php

use App\Services\Flag\Src\Flag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLayerToWhitelabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->dropColumn('layer');
        });
    }
}

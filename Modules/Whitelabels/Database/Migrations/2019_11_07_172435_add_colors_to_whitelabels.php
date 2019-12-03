<?php

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorsToWhitelabels extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('whitelabels') && !Schema::hasColumn('whitelabels', 'colors')) {
            Schema::table('whitelabels', function (Blueprint $table) {
                $table->string('color')->after('state')->default(Flag::COLOR);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
}

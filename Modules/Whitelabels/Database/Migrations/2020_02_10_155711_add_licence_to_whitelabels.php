<?php

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLicenceToWhitelabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            if (Schema::hasTable('whitelabels') && !Schema::hasColumn('whitelabels', 'licence')) {
                Schema::table('whitelabels', function (Blueprint $table) {
                    $table->enum('licence', [Flag::LIGHT, Flag::BASIC, Flag::PREMIUM, Flag::MIX])->default(Flag::LIGHT);
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
        });
    }
}

<?php

use App\Services\Flag\Src\Flag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLicenceToLanguageLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('language_lines') && !Schema::hasColumn('language_lines', 'licence')) {
            Schema::table('language_lines', function (Blueprint $table) {
                $table->enum('licence', [Flag::LIGHT, Flag::BASIC, Flag::PREMIUM, Flag::MIX])->default(Flag::LIGHT);
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
        Schema::table('', function (Blueprint $table) {

        });
    }
}

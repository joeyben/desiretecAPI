<?php

use App\Services\Flag\Src\Flag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsAutoofferToWhitelabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whitelabels', function (Blueprint $table) {
            $table->dropColumn('is_autooffer');
        });
    }
}

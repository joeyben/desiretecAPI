<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrivacyToLayers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layer_whitelabel', function (Blueprint $table) {
            if (Schema::hasTable('layer_whitelabel') && !Schema::hasColumn('layer_whitelabel', 'privacy')) {
                Schema::table('layer_whitelabel', function (Blueprint $table) {
                    $table->string('privacy')->nullable()->after('subheadline_success');
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

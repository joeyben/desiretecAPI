<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeadlineColorToLayers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('layer_whitelabel', function (Blueprint $table) {
            if (Schema::hasTable('layer_whitelabel') && !Schema::hasColumn('layer_whitelabel', 'headline_color')) {
                Schema::table('layer_whitelabel', function (Blueprint $table) {
                    $table->string('headline_color')->default('dark')->after('headline');
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
        });
    }
}

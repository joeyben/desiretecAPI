<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadlineColorToLayers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}

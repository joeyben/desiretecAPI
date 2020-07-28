<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLayerIdToWhitelabelHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('whitelabel_hosts') && !Schema::hasColumn('whitelabel_hosts', 'layer_id')) {
            Schema::table('whitelabel_hosts', function (Blueprint $table) {
                $table->integer('layer_id')->nullable()->unsigned()->index()->after('host');
            });
        }

        Schema::table('whitelabel_hosts', function (Blueprint $table) {
            $table->foreign('layer_id')->references('id')->on('layers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ('testing' !== app()->environment()) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        if (Schema::hasColumn('whitelabel_hosts', 'layer_id')) {
            Schema::table('whitelabel_hosts', function (Blueprint $table) {
                $table->dropColumn('layer_id');
            });
        }

        if ('testing' !== app()->environment()) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

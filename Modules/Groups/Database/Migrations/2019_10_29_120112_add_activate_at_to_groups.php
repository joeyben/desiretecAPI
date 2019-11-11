<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivateAtToGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('groups') && !Schema::hasColumn('groups', 'deactivate_at')) {
            Schema::table('groups', function (Blueprint $table) {
                $table->timestamp('deactivate_at')->after('whitelabel_id')->nullable();
                $table->timestamp('deactivate_until')->after('deactivate_at')->nullable();
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
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn(['deactivate_at']);
            $table->dropColumn(['deactivate_until']);
        });
    }
}

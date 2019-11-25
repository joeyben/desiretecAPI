<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivateAtToGroups extends Migration
{
    /**
     * Run the migrations.
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
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn(['deactivate_at']);
            $table->dropColumn(['deactivate_until']);
        });
    }
}

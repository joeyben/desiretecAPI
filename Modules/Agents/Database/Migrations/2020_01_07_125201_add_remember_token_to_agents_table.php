<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRememberTokenToAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('agents') && !Schema::hasColumn('agents', 'remember_token')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->string('remember_token')->after('password')->nullable();
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
        if (Schema::hasTable('agents') && Schema::hasColumn('agents', 'password')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->dropColumn(['remember_token']);
            });
        }
    }
}

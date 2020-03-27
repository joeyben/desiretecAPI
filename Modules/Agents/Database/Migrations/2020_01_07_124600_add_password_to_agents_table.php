<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordToAgentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('agents') && !Schema::hasColumn('agents', 'password')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->string('password')->after('avatar')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasTable('agents') && Schema::hasColumn('agents', 'password')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->dropColumn(['password']);
            });
        }
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPasswordToAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
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

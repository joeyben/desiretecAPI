<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoomsToWishesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('wishes') && !Schema::hasColumn('wishes', 'rooms')) {
            Schema::table('wishes', function (Blueprint $table) {
                $table->integer('rooms')->nullable()->unsigned()->after('duration');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->dropColumn('rooms');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventsInterestedAndPurposeInwishesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('wishes') && !Schema::hasColumn('wishes', 'events_interested')) {
            Schema::table('wishes', function (Blueprint $table) {
                $table->boolean('events_interested')->default(false)->nullable();
                $table->string('purpose', 255)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->dropColumn('events_interested');
            $table->dropColumn('purpose');
        });
    }
}

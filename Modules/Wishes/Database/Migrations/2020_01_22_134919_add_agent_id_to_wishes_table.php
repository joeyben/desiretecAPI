<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentIdToWishesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('wishes') && !Schema::hasColumn('wishes', 'agent_id')) {
            Schema::table('wishes', function (Blueprint $table) {
                $table->integer('agent_id')->nullable()->unsigned();
                $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('wishes', function (Blueprint $table) {
        });
    }
}

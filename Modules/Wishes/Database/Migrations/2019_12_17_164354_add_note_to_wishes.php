<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteToWishes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('wishes') && !Schema::hasColumn('wishes', 'note')) {
            Schema::table('wishes', function (Blueprint $table) {
                $table->string('note');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
        });
    }
}

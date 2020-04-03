<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertLayerInLayersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Insert some stuff
        DB::table('layers')->insert(
            array(
                'name' => 'Holiday',
                'path' => 'holiday',
                'active' => 1,
                'image' => ''
            )
        );
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

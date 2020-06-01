<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertDestinationLayerInLayersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('layers')->insert(
            array(
                'name' => 'Destination',
                'path' => 'destination',
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

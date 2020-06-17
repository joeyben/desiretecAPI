<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertHotelWebsiteLayerInLayersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('layers')->insert(
            array(
                'name' => 'Hotel_Website',
                'path' => 'hotel_website',
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

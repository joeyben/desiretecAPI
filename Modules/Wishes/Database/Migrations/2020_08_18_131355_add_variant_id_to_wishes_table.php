<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVariantIdToWishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('wishes') && !Schema::hasColumn('wishes', 'variant_id')) {
            Schema::table('wishes', function (Blueprint $table) {
                $table->integer('variant_id')->nullable()->unsigned();
                $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
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
        Schema::table('wishes', function (Blueprint $table) {

        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFootersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('footers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->smallInteger('position')->nullable();
            $table->integer('whitelabel_id')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        if (Schema::hasTable('whitelabels')) {
            Schema::table('footers', function (Blueprint $table) {
                $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('footers');
    }
}

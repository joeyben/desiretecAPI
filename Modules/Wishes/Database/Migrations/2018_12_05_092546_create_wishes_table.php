<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wishes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191);
            $table->string('featured_image', 191);
            $table->longText('description');
            $table->string('airport', 191);
            $table->string('destination', 191);
            $table->string('earliest_start', 10);
            $table->string('latest_return', 10);
            $table->integer('budget')->unsigned();
            $table->integer('adults')->unsigned();
            $table->integer('kids')->unsigned();
            $table->integer('category')->unsigned();
            $table->string('catering', 191)->nullable();
            $table->string('duration', 191)->nullable();
            $table->string('status', 191);
            $table->integer('created_by')->nullable()->unsigned()->index();
            $table->integer('updated_by')->nullable()->unsigned()->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('wishes');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191);
            $table->string('featured_image', 191);
            $table->text('description');
            $table->string('airport', 191);
            $table->string('destination', 191);
            $table->string('earliest_start', 10);
            $table->string('latest_return', 10);
            $table->integer('budget')->unsigned();;
            $table->integer('adults')->unsigned();;
            $table->integer('kids')->unsigned();
            $table->integer('category')->unsigned();;
            $table->string('catering', 191)->nullable();
            $table->string('duration', 20)->nullable();
            $table->boolean('status')->default(true);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishes');
    }
}

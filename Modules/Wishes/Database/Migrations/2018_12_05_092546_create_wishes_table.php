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
            $table->longText('description')->nullable();
            $table->string('airport', 191);
            $table->string('destination', 191);
            $table->date('earliest_start');
            $table->date('latest_return');
            $table->integer('budget')->unsigned();
            $table->integer('adults')->unsigned();
            $table->integer('kids')->unsigned();
            $table->integer('category')->unsigned();
            $table->string('catering', 191)->nullable();
            $table->string('duration', 20)->nullable();
            $table->boolean('status')->default(true);
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

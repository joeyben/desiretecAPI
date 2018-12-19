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
            $table->integer('group_id')->nullable()->unsigned()->index();
            $table->integer('updated_by')->nullable()->unsigned()->index();
            $table->integer('whitelabel_id')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('wishes', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
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
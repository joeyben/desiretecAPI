<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['manuel', 'auto', 'mix'])->default('manuel');
            $table->integer('budget')->unsigned()->nullable();
            $table->text('destinations')->nullable();

            $table->integer('user_id')->unsigned();
            $table->integer('whitelabel_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('rules', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
}

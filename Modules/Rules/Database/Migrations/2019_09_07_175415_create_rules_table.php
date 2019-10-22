<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['manuel', 'auto', 'mix'])->default('manuel');
            $table->integer('budget')->unsigned()->nullable();
            $table->text('destination')->nullable();
            $table->boolean('status')->default(false);

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
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
}

<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->integer('user_id')->unsigned();
            $table->integer('wish_id')->unsigned();
            $table->integer('agent_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wish_id')->references('id')->on('wishes')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('message');

        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

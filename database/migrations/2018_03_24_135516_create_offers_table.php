<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->text('description');
            $table->enum('status', ['Active', 'Deleted', 'InActive']);
            $table->string('file', 200);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('wish_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        if (Schema::hasTable('agents')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->integer('agent_id')->after('wish_id')->nullable()->unsigned()->index();
                $table->foreign('agent_id')->references('id')->on('agents')->onDelete('agents');
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
        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('offers');

        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

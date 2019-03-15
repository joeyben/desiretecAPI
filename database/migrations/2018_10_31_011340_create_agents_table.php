<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('display_name', 200);
            $table->string('email', 191)->unique();
            $table->string('telephone', 191);
            $table->enum('status', ['Active', 'Deleted', 'InActive']);
            $table->string('avatar', 200);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        if (Schema::hasTable('offers')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->integer('agent_id')->after('wish_id')->nullable()->unsigned()->index();
                $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('agents');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

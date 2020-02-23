<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhitelabelAutoofferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whitelabel_autooffer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('whitelabel_id')->unsigned();
            $table->string('username', 191);
            $table->string('password', 191);
            $table->string('token', 191);
            $table->tinyInteger('type')->unsigned();
            $table->text('tourOperators');
            $table->timestamps();
        });

        Schema::table('whitelabel_autooffer', function (Blueprint $table) {
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
        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('whitelabel_autooffer');

        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

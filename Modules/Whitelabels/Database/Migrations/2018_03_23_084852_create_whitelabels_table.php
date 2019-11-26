<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWhitelabelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('whitelabels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->string('display_name', 191);
            $table->string('domain', 191)->nullable();
            $table->boolean('status')->default(true);
            $table->integer('ga_view_id')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->smallInteger('state')->default(0);
            $table->string('bg_image', 191)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('whitelabels', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        if (Schema::hasTable('distributions')) {
            Schema::table('whitelabels', function (Blueprint $table) {
                $table->integer('distribution_id')->after('created_by')->nullable()->unsigned()->index();
                $table->foreign('distribution_id')->references('id')->on('distributions')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('whitelabels');

        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->integer('budget')->unsigned()->default(0);
            $table->integer('adults')->unsigned();
            $table->integer('kids')->unsigned();
            $table->integer('category')->unsigned();
            $table->string('catering', 191)->nullable();
            $table->string('duration', 20)->nullable();
            $table->boolean('status')->default(true);
            $table->enum('booking_status', ['open', 'booked', 'cancelled'])->default('open');
            $table->integer('created_by')->nullable()->unsigned()->index();
            $table->integer('updated_by')->nullable()->unsigned()->index();
            $table->integer('whitelabel_id')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        if (Schema::hasTable('groups')) {
            Schema::table('wishes', function (Blueprint $table) {
                $table->integer('group_id')->after('created_by')->nullable()->unsigned()->index();
                $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            });
        }

        Schema::table('wishes', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('wishes');

        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

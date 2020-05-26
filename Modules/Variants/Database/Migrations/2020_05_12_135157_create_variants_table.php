<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->increments('id');
            $table->text('headline');
            $table->text('subheadline');
            $table->string('color');
            $table->string('layer_url');
            $table->text('headline_success');
            $table->text('subheadline_success');
            $table->string('privacy');
            $table->integer('layer_whitelabel_id')->nullable()->unsigned()->index();
            $table->integer('whitelabel_id')->nullable()->unsigned();
            $table->integer('user_id')->nullable()->unsigned()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('variants', function (Blueprint $table) {
            $table->foreign('layer_whitelabel_id')->references('id')->on('layer_whitelabel')->onDelete('cascade');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
}

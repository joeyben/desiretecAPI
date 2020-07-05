<?php

use Illuminate\Support\Facades\DB;
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
            $table->string('name')->nullable();
            $table->string('layer_url')->nullable();
            $table->text('headline')->nullable();
            $table->text('subheadline');
            $table->string('color')->default('#ED653D');
            $table->text('headline_success')->nullable();
            $table->text('subheadline_success')->nullable();
            $table->string('privacy')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('layer_whitelabel_id')->nullable()->unsigned()->index();
            $table->integer('whitelabel_id')->nullable()->unsigned();
            $table->integer('user_id')->nullable()->unsigned()->index();
            $table->integer('whitelabel_host_id')->nullable()->unsigned()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('variants', function (Blueprint $table) {
            $table->foreign('layer_whitelabel_id')->references('id')->on('layer_whitelabel')->onDelete('cascade');
            $table->foreign('whitelabel_id')->references('id')->on('whitelabels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('whitelabel_host_id', 'host')->references('id')->on('whitelabel_hosts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ('testing' !== app()->environment()) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('variants');

        if ('testing' !== app()->environment()) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}

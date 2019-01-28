<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->string('display_name', 191);
            $table->text('description');
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        if (Schema::hasTable('whitelabels') && !Schema::hasColumn('whitelabels', 'distribution_id')) {
            Schema::table('whitelabels', function (Blueprint $table) {
                $table->integer('distribution_id')->after('created_by')->nullable()->unsigned()->index();
                $table->foreign('distribution_id')->references('id')->on('distributions')->onDelete('cascade');
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
        Schema::dropIfExists('distributions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

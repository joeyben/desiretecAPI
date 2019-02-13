<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->integer('user_id')->unsigned()->index('notifications_user_id_foreign');
            $table->boolean('type')->default(1)->comment('1 - Dashboard , 2 - Email , 3 - Both');
            $table->boolean('is_read')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        if (Schema::hasTable('users') && !Schema::hasColumn('notifications', 'from_id')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->integer('from_id')->unsigned()->index()->nullable();
                $table->foreign('from_id', 'from')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('notifications');
    }
}

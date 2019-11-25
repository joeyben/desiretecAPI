<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeadlineToWhitelabels extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('', function (Blueprint $table) {
        });

        if (Schema::hasTable('whitelabels') && !Schema::hasColumn('whitelabels', 'headline')) {
            Schema::table('whitelabels', function (Blueprint $table) {
                $table->string('headline')->after('state')->nullable();
                $table->text('subheadline')->after('state')->nullable();
                $table->string('headline_success')->after('state')->nullable();
                $table->text('subheadline_success')->after('state')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
        });
    }
}

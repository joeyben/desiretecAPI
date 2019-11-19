<?php

use App\Services\Flag\Src\Flag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadlineToWhitelabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}

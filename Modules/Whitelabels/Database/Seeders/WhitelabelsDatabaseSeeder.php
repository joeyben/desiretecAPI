<?php

namespace Modules\Whitelabels\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WhitelabelsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('whitelabels')->insertGetId([
            'name'             => '',
            'display_name'    => '',
            'status'       => '',
            'created_at'        => DB::raw('now()'),
            'updated_at'        => DB::raw('now()'),
        ]);
    }
}

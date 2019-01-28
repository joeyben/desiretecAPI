<?php

namespace Modules\Whitelabels\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WhitelabelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        if (!DB::table('distributions')->where('name', 'round-robin')->exists()) {
            DB::table('distributions')->insertGetId([
                'name'              => 'round-robin',
                'display_name'      => 'Round Robin',
                'description'       => 'Round Robin',
                'created_by'        => 1,
                'created_at'        => DB::raw('now()'),
                'updated_at'        => DB::raw('now()'),
            ]);
        }

        if (!DB::table('distributions')->where('name', 'regional')->exists()) {
            DB::table('distributions')->insertGetId([
                'name'              => 'regional',
                'display_name'      => 'Regional',
                'description'       => 'Regional Distribution',
                'created_by'        => 1,
                'created_at'        => DB::raw('now()'),
                'updated_at'        => DB::raw('now()'),
            ]);
        }

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'tui',
            'display_name'            => 'TUI Deutschland',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => DB::raw('now()'),
            'updated_at'              => DB::raw('now()'),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'aida',
            'display_name'            => 'Aida',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 2,
            'state'                   => 3,
            'created_at'              => DB::raw('now()'),
            'updated_at'              => DB::raw('now()'),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'tuisp',
            'display_name'            => 'TUI Spain',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => DB::raw('now()'),
            'updated_at'              => DB::raw('now()'),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'tcook',
            'display_name'            => 'Thomas Cook',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => DB::raw('now()'),
            'updated_at'              => DB::raw('now()'),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'tui-pg',
            'display_name'            => 'TUI Portugal',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => DB::raw('now()'),
            'updated_at'              => DB::raw('now()'),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'nmviajes',
            'display_name'            => 'Nmviajes',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => DB::raw('now()'),
            'updated_at'              => DB::raw('now()'),
        ]);
    }
}

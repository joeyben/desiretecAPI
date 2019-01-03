<?php

namespace Modules\Dashboard\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DashboardDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        DB::table('dashboards')->insert([
            'name'            => 'Tile Comment',
            'x'               => 0,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 0,
            'component'       => 'tile-comment-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Click',
            'x'               => 2,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 1,
            'component'       => 'tile-click-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Event',
            'x'               => 4,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 2,
            'component'       => 'tile-event-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile User',
            'x'               => 6,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 3,
            'component'       => 'tile-user-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Order',
            'x'               => 8,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 4,
            'component'       => 'tile-order-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Comment',
            'x'               => 10,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 5,
            'component'       => 'tile-comment-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile update',
            'x'               => 0,
            'y'               => 2,
            'w'               => 4,
            'h'               => 8,
            'i'               => 6,
            'component'       => 'tile-update-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile spider',
            'x'               => 4,
            'y'               => 2,
            'w'               => 4,
            'h'               => 8,
            'i'               => 7,
            'component'       => 'tile-spider-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile pie',
            'x'               => 8,
            'y'               => 2,
            'w'               => 4,
            'h'               => 8,
            'i'               => 8,
            'component'       => 'tile-pie-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile chart',
            'x'               => 0,
            'y'               => 5,
            'w'               => 4,
            'h'               => 8,
            'i'               => 9,
            'component'       => 'tile-chart-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile bar',
            'x'               => 4,
            'y'               => 5,
            'w'               => 4,
            'h'               => 8,
            'i'               => 10,
            'component'       => 'tile-bar-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile 3D',
            'x'               => 8,
            'y'               => 5,
            'w'               => 4,
            'h'               => 8,
            'i'               => 11,
            'component'       => 'tile-td-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        for ($i = 1; $i <= 12; ++$i) {
            DB::table('dashboard_user')->insertGetId([
                'user_id'              => 1,
                'dashboard_id'         => $i,
            ]);
        }
    }
}

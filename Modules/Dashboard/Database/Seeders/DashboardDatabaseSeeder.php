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
            'name'            => 'Tile Wish',
            'x'               => 0,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 0,
            'component'       => 'tile-wish-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Offer',
            'x'               => 0,
            'y'               => 15,
            'w'               => 4,
            'h'               => 8,
            'i'               => 4,
            'component'       => 'tile-offer-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Mobile',
            'x'               => 0,
            'y'               => 23,
            'w'               => 4,
            'h'               => 8,
            'i'               => 15,
            'component'       => 'tile-mobile-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Response',
            'x'               => 0,
            'y'               => 31,
            'w'               => 4,
            'h'               => 8,
            'i'               => 16,
            'component'       => 'tile-response-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Response Mobile',
            'x'               => 6,
            'y'               => 31,
            'w'               => 4,
            'h'               => 8,
            'i'               => 17,
            'component'       => 'tile-responsem-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Offerday',
            'x'               => 6,
            'y'               => 15,
            'w'               => 4,
            'h'               => 8,
            'i'               => 14,
            'component'       => 'tile-offerday-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Seller',
            'x'               => 2,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 1,
            'component'       => 'tile-seller-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Group',
            'x'               => 4,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 2,
            'component'       => 'tile-group-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Reaction Time',
            'x'               => 6,
            'y'               => 0,
            'w'               => 3,
            'h'               => 2,
            'i'               => 3,
            'component'       => 'tile-user-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Tile Comment',
            'x'               => 9,
            'y'               => 0,
            'w'               => 3,
            'h'               => 2,
            'i'               => 5,
            'component'       => 'tile-comment-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Chart Wish',
            'x'               => 0,
            'y'               => 2,
            'w'               => 4,
            'h'               => 8,
            'i'               => 6,
            'component'       => 'chart-wish-component',
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
            'name'            => 'Wishes overall per day',
            'x'               => 0,
            'y'               => 5,
            'w'               => 4,
            'h'               => 8,
            'i'               => 9,
            'component'       => 'chart-wish-day-component',
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

        DB::table('dashboards')->insert([
            'name'            => 'GA Datatable',
            'x'               => 0,
            'y'               => 0,
            'w'               => 12,
            'h'               => 5,
            'i'               => 12,
            'component'       => 'ga-datatable-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Backend Analytics',
            'x'               => 0,
            'y'               => 0,
            'w'               => 12,
            'h'               => 10,
            'i'               => 13,
            'component'       => 'backend-analytics-component',
            'created_at'      => DB::raw('now()'),
            'updated_at'      => DB::raw('now()')
        ]);

        for ($i = 0; $i <= 17; ++$i) {
            DB::table('dashboard_user')->insertGetId([
                'user_id'              => 1,
                'dashboard_id'         => $i,
            ]);
        }
    }
}

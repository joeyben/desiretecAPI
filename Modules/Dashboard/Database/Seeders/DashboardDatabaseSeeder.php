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
            'name'            => 'Alle Wünsche',
            'x'               => 0,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 1,
            'component'       => 'tile-wish-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'LI Desktop Monat',
            'x'               => 0,
            'y'               => 15,
            'w'               => 4,
            'h'               => 8,
            'i'               => 2,
            'component'       => 'tile-offer-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'LI Mobile Monat',
            'x'               => 0,
            'y'               => 23,
            'w'               => 4,
            'h'               => 8,
            'i'               => 3,
            'component'       => 'tile-mobile-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Response Rate Desktop Gesamt',
            'x'               => 0,
            'y'               => 31,
            'w'               => 4,
            'h'               => 8,
            'i'               => 4,
            'component'       => 'tile-response-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Response Rate Mobile Gesamt',
            'x'               => 6,
            'y'               => 31,
            'w'               => 4,
            'h'               => 8,
            'i'               => 5,
            'component'       => 'tile-responsem-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'LI Desktop Tag',
            'x'               => 6,
            'y'               => 15,
            'w'               => 4,
            'h'               => 8,
            'i'               => 6,
            'component'       => 'tile-offerday-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Anbieter',
            'x'               => 2,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 7,
            'component'       => 'tile-seller-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Gruppen',
            'x'               => 4,
            'y'               => 0,
            'w'               => 2,
            'h'               => 2,
            'i'               => 8,
            'component'       => 'tile-group-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Reaktionszeit',
            'x'               => 6,
            'y'               => 0,
            'w'               => 3,
            'h'               => 2,
            'i'               => 9,
            'component'       => 'tile-user-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Alle Wünsche pro Monat',
            'x'               => 0,
            'y'               => 2,
            'w'               => 4,
            'h'               => 8,
            'i'               => 11,
            'component'       => 'chart-wish-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'LI Desktop Monat Browser',
            'x'               => 8,
            'y'               => 2,
            'w'               => 4,
            'h'               => 8,
            'i'               => 13,
            'component'       => 'tile-pie-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Alle Wünsche pro Tag',
            'x'               => 0,
            'y'               => 5,
            'w'               => 4,
            'h'               => 8,
            'i'               => 14,
            'component'       => 'chart-wish-day-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'LI Mobile Tag',
            'x'               => 6,
            'y'               => 23,
            'w'               => 4,
            'h'               => 8,
            'i'               => 19,
            'component'       => 'tile-mobiled-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Klicks Desktop Monat Browser',
            'x'               => 6,
            'y'               => 31,
            'w'               => 4,
            'h'               => 8,
            'i'               => 20,
            'component'       => 'tile-share-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Click-Rate Angebot manuell',
            'x'               => 0,
            'y'               => 40,
            'w'               => 4,
            'h'               => 8,
            'i'               => 21,
            'component'       => 'tile-clickrate-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Open-Rate Angebot manuell',
            'x'               => 6,
            'y'               => 40,
            'w'               => 4,
            'h'               => 8,
            'i'               => 22,
            'component'       => 'tile-openrate-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Click-Rate Angebot Auto',
            'x'               => 0,
            'y'               => 48,
            'w'               => 4,
            'h'               => 8,
            'i'               => 23,
            'component'       => 'tile-clickrateauto-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        DB::table('dashboards')->insert([
            'name'            => 'Open-Rate Angebot Auto',
            'x'               => 6,
            'y'               => 48,
            'w'               => 4,
            'h'               => 8,
            'i'               => 24,
            'component'       => 'tile-openrateauto-component',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);

        for ($i = 1; $i <= 24; ++$i) {
            DB::table('dashboard_user')->insertGetId([
                'user_id'              => 1,
                'dashboard_id'         => $i,
            ]);
        }

        $this->call(FilterCategorySeeder::class);
    }
}

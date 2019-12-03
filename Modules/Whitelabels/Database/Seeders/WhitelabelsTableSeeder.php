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
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        if (!DB::table('distributions')->where('name', 'regional')->exists()) {
            DB::table('distributions')->insertGetId([
                'name'              => 'regional',
                'display_name'      => 'Regional',
                'description'       => 'Regional Distribution',
                'created_by'        => 1,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Master',
            'display_name'            => 'master',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Trendtours',
            'display_name'            => 'Trendtours',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 2,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Lastminute',
            'display_name'            => 'Lastminute',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Tuidemo',
            'display_name'            => 'Tuidemo',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Traveloverland',
            'display_name'            => 'Traveloverland',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Reiseexperten',
            'display_name'            => 'Reiseexperten',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Tui',
            'display_name'            => 'tui',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Demokreuzfahrtberatung',
            'display_name'            => 'demokreuzfahrtberatung',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Demoreiserebellen',
            'display_name'            => 'demoreiserebellen',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Testkurenundwellness',
            'display_name'            => 'testkurenundwellness',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        DB::table('whitelabels')->insertGetId([
            'name'                    => 'Demoatw',
            'display_name'            => 'Demoatw',
            'status'                  => true,
            'created_by'              => 1,
            'distribution_id'         => 1,
            'state'                   => 3,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(2)->whitelabels()->sync([1]);
        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(3)->whitelabels()->sync([1]);
    }
}

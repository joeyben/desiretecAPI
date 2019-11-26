<?php

namespace Modules\Footers\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FootersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        DB::table('footers')->insertGetId([
            'name'       => 'Über uns',
            'url'        => 'javascript:;',
            'position'   => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('footers')->insertGetId([
            'name'       => 'Datenschutz',
            'url'        => 'javascript:;',
            'position'   => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('footers')->insertGetId([
            'name'       => 'Nutzungsbedingung',
            'url'        => 'javascript:;',
            'position'   => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('footers')->insertGetId([
            'name'       => 'Allgemeine Geschäftsbedingungen',
            'url'        => 'javascript:;',
            'position'   => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('footers')->insertGetId([
            'name'       => 'Impressum',
            'url'        => 'javascript:;',
            'position'   => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

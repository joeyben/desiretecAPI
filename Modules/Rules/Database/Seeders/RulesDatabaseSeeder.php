<?php

namespace Modules\Rules\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RulesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $faker = \Faker\Factory::create();

        foreach (config('rules.permissions', []) as $key => $value) {
            if (!DB::table('permissions')->where('name', str_slug($value))->exists()) {
                DB::table('permissions')->insertGetId([
                    'name'         => str_slug($value),
                    'display_name' => $value,
                    'status'       => 1,
                    'created_at'   => now(),
                    'updated_at'   => now()
                ]);
            }
        }

        for ($i = 1; $i <= 2; ++$i) {
            DB::table('rules')->insertGetId([
                'type'              => 'manuel',
                'budget'            => 3000,
                'destination'       => json_encode(['Malediven', 'Paris']),
                'user_id'           => 1,
                'whitelabel_id'     => 16,
                'created_at'        => $faker->dateTimeThisMonth(),
                'updated_at'        => now(),
            ]);
        }
    }
}

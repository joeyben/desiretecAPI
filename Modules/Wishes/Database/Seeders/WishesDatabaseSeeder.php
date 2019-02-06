<?php

namespace Modules\Wishes\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WishesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        $faker = \Faker\Factory::create();
        foreach (config('wishes.permissions', []) as $key => $value) {
            if (!DB::table('permissions')->where('name', str_slug($value))->exists()) {
                DB::table('permissions')->insertGetId([
                    'name'         => str_slug($value),
                    'display_name' => $value,
                    'status'       => 1,
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()')
                ]);
            }
        }

        for ($i = 1; $i <= 100; ++$i) {
            DB::table('wishes')->insertGetId([
                'title'             => $faker->name,
                'featured_image'    => $faker->imageUrl(),
                'description'       => $faker->sentence(100),
                'airport'           => 'Airport ' . $faker->city,
                'destination'       => $faker->city,
                'earliest_start'    => $faker->date(),
                'latest_return'     => $faker->date(),
                'budget'            => $faker->numberBetween(1000, 3000),
                'kids'              => $faker->numberBetween(1, 5),
                'adults'            => $faker->numberBetween(1, 5),
                'category'          => $faker->numberBetween(1, 5),
                'catering'          => $faker->name,
                'duration'          => $faker->numberBetween(1, 5),
                'created_by'        => $faker->numberBetween(12, 16),
                'updated_by'        => $faker->numberBetween(1, 3),
                'group_id'          => $faker->numberBetween(1, 5),
                'whitelabel_id'     => $faker->numberBetween(1, 5),
                'created_at'        => DB::raw('now()'),
                'updated_at'        => DB::raw('now()'),
            ]);
        }
    }
}

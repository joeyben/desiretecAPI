<?php

namespace Modules\Notifications\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $faker = \Faker\Factory::create();

        foreach (config('notifications.permissions', []) as $key => $value) {
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
        for ($i = 1; $i <= 10; ++$i) {
            DB::table('notifications')->insertGetId([
                'message'    => $faker->sentence(),
                'user_id'    => $faker->numberBetween(1, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

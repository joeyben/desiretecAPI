<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RoleTableSeeder;
use UserRoleSeeder;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach (config('roles.permissions', []) as $key => $value) {
            if (!DB::table('permissions')->where('name', \str_slug($value))->exists()) {
                DB::table('permissions')->insertGetId([
                    'name'         => \str_slug($value),
                    'display_name' => $value,
                    'status'       => 1,
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()')
                ]);
            }
        }

        $this->call(RoleTableSeeder::class);
        $this->call(UserRoleSeeder::class);
    }
}

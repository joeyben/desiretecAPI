<?php

namespace Modules\Permissions\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PermissionRoleSeeder;
use PermissionTableSeeder;
use PermissionUserSeeder;

class PermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        foreach (config('permissions.permissions', []) as $key => $value) {
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
        $this->call(PermissionTableSeeder::class);
        $this->call(PermissionRoleSeeder::class);
        $this->call(PermissionUserSeeder::class);
    }
}

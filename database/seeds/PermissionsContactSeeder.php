<?php

use Carbon\Carbon;
use Database\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionsContactSeeder.
 */
class PermissionsContactSeeder extends Seeder
{
    const PERMISSIONS = [
        ['name' => 'View Contact'],
        ['name' => 'Create Contact'],
        ['name' => 'Edit Contact'],
        ['name' => 'Delete Contact'],
        ['name' => 'View Contact frontend'],
    ];
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        /**
         * Don't need to assign any permissions to administrator because the all flag is set to true
         * in RoleTableSeeder.php.
         */

        /**
         * Misc Access Permissions.
         */
        foreach ($this::PERMISSIONS as $key => $value) {
            if (!DB::table('permissions')->where('name', str_slug($value['name']))->exists()) {
                DB::table('permissions')->insertGetId([
                    'name' => str_slug($value['name']),
                    'display_name' => $value['name'],
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        if(app()->environment() !== 'testing') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}


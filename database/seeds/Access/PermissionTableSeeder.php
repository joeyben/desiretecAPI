<?php

use Carbon\Carbon;
use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionTableSeeder.
 */
class PermissionTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncateMultiple([config('access.permissions_table'), config('access.permission_role_table')]);

        /**
         * Don't need to assign any permissions to administrator because the all flag is set to true
         * in RoleTableSeeder.php.
         */

        /**
         * Misc Access Permissions.
         */
        foreach (\App\Services\Flag\Src\Role::PERMISSIONS as $key => $value) {
            if (!DB::table('permissions')->where('name', str_slug($value['name']))->exists()) {
                DB::table('permissions')->insertGetId([
                    'name' => str_slug($value['name']),
                    'display_name' => $value['name'],
                    'status' => 1,
                    'created_at' => DB::raw('now()'),
                    'updated_at' => DB::raw('now()')
                ]);
            }
        }

        $this->enableForeignKeys();
    }
}

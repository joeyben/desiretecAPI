<?php

use App\Models\Access\Role\Role;
use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleSeeder.
 */
class PermissionRoleSeeder extends Seeder
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
        $this->truncate(config('access.permission_role_table'));

        /*
         * Assign permission to executive role
        */
        $executivePermission = [
            1, 3, 4, 5, 6, 7, 8, 9,
            10, 11, 13, 14, 15, // CMS Pages
            16, 43, 44, // Blogs
            45, 46, 48, 50, // FAQ
            52, 53, 58, 67, // FAQ
            68, 69, 70, 72, // FAQ
            73, 74, 89, 90,// FAQ
        ];

        Role::find(2)->permissions()->sync($executivePermission);

        /*
         * Assign view frontend to user role
        */
        $sellerPermission = [
            2, 43, 44, 45, 46,
            50, 52, 53, 58, // CMS Pages
            59, 60, 61, 62, // Email template
            63, 64, 65, 66, // Blog Category
            78, 79, 80, 81, // Blog Tag
        ];

        Role::find(3)->permissions()->sync($sellerPermission);

        /*
         * Assign view frontend to user role
        */
        $userPermission = [
            43, 44, 45, 46, 48, 49, 50, 51, 52,
            53, // CMS Pages
        ];

        Role::find(4)->permissions()->sync($userPermission);

        $this->enableForeignKeys();
    }
}

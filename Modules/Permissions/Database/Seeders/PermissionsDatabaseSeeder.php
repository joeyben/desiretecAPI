<?php

namespace Modules\Permissions\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
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

        $this->call(PermissionTableSeeder::class);
        $this->call(PermissionRoleSeeder::class);
        $this->call(PermissionUserSeeder::class);
    }
}

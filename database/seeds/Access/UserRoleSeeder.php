<?php

use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleSeeder.
 */
class UserRoleSeeder extends Seeder
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
        $this->truncate(config('access.role_user_table'));

        //Attach admin role to admin user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::first()->attachRole(1);

        //Attach executive role to executive user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(2)->attachRole(1);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(3)->attachRole(1);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(4)->attachRole(2);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(5)->attachRole(3);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(6)->attachRole(3);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(7)->attachRole(3);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(8)->attachRole(3);

        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(9)->attachRole(3);


        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(10)->attachRole(3);



        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(11)->attachRole(3);

        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(12)->attachRole(4);

        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(13)->attachRole(4);

        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(14)->attachRole(4);

        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(15)->attachRole(4);

        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model();
        $user_model::find(16)->attachRole(4);

        $this->enableForeignKeys();
    }
}

<?php

use Carbon\Carbon as Carbon;
use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
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
        $this->truncate(config('access.users_table'));

        //Add the master administrator, user id of 1
        $users = [
            [
                'first_name'        => 'Viral',
                'last_name'         => 'Solani',
                'email'             => 'admin@admin.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'Joe',
                'last_name'         => 'Admin',
                'email'             => 'joe-admin@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'Goldoni',
                'last_name'         => 'Admin',
                'email'             => 'goldoni-admin@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'Tui',
                'last_name'         => 'Admin',
                'email'             => 'tui@executive.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'Tui',
                'last_name'         => 'Seller',
                'email'             => 'tui@seller.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'Joe',
                'last_name'         => 'Seller',
                'email'             => 'joe+tuiseller@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'John',
                'last_name'         => 'Seller 1',
                'email'             => 'john+seller1@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'John',
                'last_name'         => 'Seller 2',
                'email'             => 'john+seller2@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'John',
                'last_name'         => 'Seller 3',
                'email'             => 'john+seller3@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'John',
                'last_name'         => 'Seller 4',
                'email'             => 'john+seller4@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'John',
                'last_name'         => 'Seller 5',
                'email'             => 'john+seller5@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'Tui',
                'last_name'         => 'User',
                'email'             => 'tui@user.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'Joe',
                'last_name'         => 'User',
                'email'             => 'joe-user@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'Goldoni',
                'last_name'         => 'User',
                'email'             => 'goldoni-user@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'John',
                'last_name'         => 'Doe',
                'email'             => 'john-doe@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
            [
                'first_name'        => 'John',
                'last_name'         => 'Doe1',
                'email'             => 'john-doe1@desiretec.com',
                'password'          => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'created_by'        => 1,
                'updated_by'        => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
                'deleted_at'        => null,
            ],
        ];

        DB::table(config('access.users_table'))->insert($users);

        $this->enableForeignKeys();
    }
}

<?php

namespace Modules\DesiretecDemo\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DesiretecDemoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}

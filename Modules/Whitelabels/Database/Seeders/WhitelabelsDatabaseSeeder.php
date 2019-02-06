<?php

namespace Modules\Whitelabels\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class WhitelabelsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->call(WhitelabelsTableSeeder::class);
    }
}

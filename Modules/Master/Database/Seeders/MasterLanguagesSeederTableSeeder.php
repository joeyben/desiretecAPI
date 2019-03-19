<?php

namespace Modules\Master\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterLanguagesSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $language = DB::table('languages')->where('locale', \Config::get('master.locale'))->first();


        DB::table('language_whitelabel')->insert([
            'language_id' => $language->id,
            'whitelabel_id' => \Config::get('master.id')
        ]);
    }
}

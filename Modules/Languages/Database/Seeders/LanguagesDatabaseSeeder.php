<?php

namespace Modules\Languages\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        /**
         * Get locales from config.
         */
        $locales = array_keys(config('locale.languages'));

        $languages = [];

        foreach ($locales as $locale) {
            $language = [
                'locale'     => $locale,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            array_push($languages, $language);
        }

        DB::table('languages')->insert($languages);
    }
}

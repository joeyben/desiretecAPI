<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AccessTableSeeder::class);
        $this->call(HistoryTypeTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(\Modules\Whitelabels\Database\Seeders\WhitelabelsTableSeeder::class);
        $this->call(\Modules\Groups\Database\Seeders\GroupsDatabaseSeeder::class);
        $this->call(\Modules\Wishes\Database\Seeders\WishesDatabaseSeeder::class);

        Model::reguard();
    }
}

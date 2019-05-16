<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Languages\Database\Seeders\LanguagesDatabaseSeeder;

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
        $this->call(PermissionsContactSeeder::class);
        $this->call(\Modules\Whitelabels\Database\Seeders\WhitelabelsTableSeeder::class);
        $this->call(\Modules\Groups\Database\Seeders\GroupsDatabaseSeeder::class);
        $this->call(\Modules\Wishes\Database\Seeders\WishesDatabaseSeeder::class);
        $this->call(\Modules\Dashboard\Database\Seeders\DashboardDatabaseSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(LanguagesDatabaseSeeder::class);

        Model::reguard();
    }
}

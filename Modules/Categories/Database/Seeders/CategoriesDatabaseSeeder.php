<?php

namespace Modules\Categories\Database\Seeders;

use BrianFaust\Categories\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        foreach (config('categories.permissions', []) as $key => $value) {
            if (!DB::table('permissions')->where('name', str_slug($value))->exists()) {
                DB::table('permissions')->insertGetId([
                    'name'         => str_slug($value),
                    'display_name' => $value,
                    'status'       => 1,
                    'created_at'   => DB::raw('now()'),
                    'updated_at'   => DB::raw('now()')
                ]);
            }
        }

        $parent = Category::create([
            'name'     => 'Hotel Categories',
            'children' => [
                [
                    'name' => '1 Stern',
                ]
            ]
        ]);
        $parent->children()->create([
            'name' => '2 Stern'
        ]);
        $parent->children()->create([
            'name' => '3 Stern'
        ]);
        $parent->children()->create([
            'name' => '4 Stern'
        ]);
        $parent->children()->create([
            'name' => '5 Stern'
        ]);
        $parent = Category::create([
            'name'     => 'Hotel Catering',
            'children' => [
                [
                    'name' => 'Beliebig',
                ]
            ]
        ]);
        $parent->children()->create([
            'name' => 'ohne Verpflegung'
        ]);
        $parent->children()->create([
            'name' => 'Frühstück'
        ]);
        $parent->children()->create([
            'name' => 'Halbpension'
        ]);
        $parent->children()->create([
            'name' => 'Vollpension'
        ]);
        $parent->children()->create([
            'name' => 'all inclusive'
        ]);
    }
}

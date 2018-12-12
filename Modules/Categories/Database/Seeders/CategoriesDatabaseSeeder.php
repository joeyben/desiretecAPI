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
            if (!DB::table('permissions')->where('name', \str_slug($value))->exists()) {
                DB::table('permissions')->insertGetId([
                    'name'         => \str_slug($value),
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
                    'name' => '1 Star',
                ]
            ]
        ]);
        $parent->children()->create([
            'name' => '2 Stars'
        ]);
        $parent->children()->create([
            'name' => '3 Stars'
        ]);
        $parent->children()->create([
            'name' => '4 Stars'
        ]);
        $parent->children()->create([
            'name' => '5 Stars'
        ]);
        $parent = Category::create([
            'name'     => 'Hotel Catering',
            'children' => [
                [
                    'name' => 'Any',
                ]
            ]
        ]);
        $parent->children()->create([
            'name' => 'Breakfast'
        ]);
        $parent->children()->create([
            'name' => 'Pension'
        ]);
        $parent->children()->create([
            'name' => 'Full Pension'
        ]);
        $parent->children()->create([
            'name' => 'All Inclusive'
        ]);
    }
}

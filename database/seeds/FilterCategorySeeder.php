<?php

use Illuminate\Database\Seeder;

class FilterCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('filter_category')->insert([
            'name'            => 'Basis',
            'shown'           => 1,
            'position'        => 0
        ]);
        DB::table('filter_category')->insert([
            'name'            => 'Wünsche',
            'shown'           => 1,
            'position'        => 1
        ]);
        DB::table('filter_category')->insert([
            'name'            => 'LI Desktop',
            'shown'           => 1,
            'position'        => 2
        ]);
        DB::table('filter_category')->insert([
            'name'            => 'LI Mobile',
            'shown'           => 1,
            'position'        => 3
        ]);
        DB::table('filter_category')->insert([
            'name'            => 'Desktop Browser',
            'shown'           => 1,
            'position'        => 4
        ]);
        DB::table('filter_category')->insert([
            'name'            => 'Response Rate',
            'shown'           => 1,
            'position'        => 5
        ]);
    }
}

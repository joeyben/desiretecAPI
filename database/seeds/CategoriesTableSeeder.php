<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'adults',
                'slug' => 'adults',
                'type' => 'default',
                '_lft' => 1,
                '_rgt' => 12,
                'parent_id' => NULL,
                'created_at' => '2019-02-04 10:28:10',
                'updated_at' => '2019-02-04 10:28:10',
                'value' => '',
            ),
            1 => 
            array (
                'id' => 5,
                'name' => '1',
                'slug' => '1',
                'type' => 'default',
                '_lft' => 2,
                '_rgt' => 3,
                'parent_id' => 4,
                'created_at' => '2019-02-04 10:29:11',
                'updated_at' => '2019-02-08 14:23:33',
                'value' => '1',
            ),
            2 => 
            array (
                'id' => 6,
                'name' => '2',
                'slug' => '2',
                'type' => 'default',
                '_lft' => 4,
                '_rgt' => 5,
                'parent_id' => 4,
                'created_at' => '2019-02-04 10:29:17',
                'updated_at' => '2019-02-08 14:23:45',
                'value' => '2',
            ),
            3 => 
            array (
                'id' => 7,
                'name' => '3',
                'slug' => '3',
                'type' => 'default',
                '_lft' => 6,
                '_rgt' => 7,
                'parent_id' => 4,
                'created_at' => '2019-02-04 10:29:42',
                'updated_at' => '2019-02-08 14:23:55',
                'value' => '3',
            ),
            4 => 
            array (
                'id' => 8,
                'name' => '4',
                'slug' => '4',
                'type' => 'default',
                '_lft' => 8,
                '_rgt' => 9,
                'parent_id' => 4,
                'created_at' => '2019-02-04 10:29:50',
                'updated_at' => '2019-02-08 14:24:03',
                'value' => '4',
            ),
            5 => 
            array (
                'id' => 9,
                'name' => '5',
                'slug' => '5',
                'type' => 'default',
                '_lft' => 10,
                '_rgt' => 11,
                'parent_id' => 4,
                'created_at' => '2019-02-04 10:29:57',
                'updated_at' => '2019-02-08 14:24:10',
                'value' => '5',
            ),
            6 => 
            array (
                'id' => 10,
                'name' => 'kids',
                'slug' => 'kids',
                'type' => 'default',
                '_lft' => 13,
                '_rgt' => 22,
                'parent_id' => NULL,
                'created_at' => '2019-02-08 14:41:28',
                'updated_at' => '2019-02-08 14:41:28',
                'value' => 'kids',
            ),
            7 => 
            array (
                'id' => 11,
                'name' => '0',
                'slug' => '0-1',
                'type' => 'default',
                '_lft' => 14,
                '_rgt' => 15,
                'parent_id' => 10,
                'created_at' => '2019-02-08 14:41:35',
                'updated_at' => '2019-02-08 14:42:29',
                'value' => '0',
            ),
            8 => 
            array (
                'id' => 12,
                'name' => '1',
                'slug' => '1-2',
                'type' => 'default',
                '_lft' => 16,
                '_rgt' => 17,
                'parent_id' => 10,
                'created_at' => '2019-02-08 14:41:40',
                'updated_at' => '2019-02-08 14:43:19',
                'value' => '1',
            ),
            9 => 
            array (
                'id' => 13,
                'name' => '2',
                'slug' => '2-1',
                'type' => 'default',
                '_lft' => 18,
                '_rgt' => 19,
                'parent_id' => 10,
                'created_at' => '2019-02-08 14:41:47',
                'updated_at' => '2019-02-08 14:43:27',
                'value' => '2',
            ),
            10 => 
            array (
                'id' => 14,
                'name' => '3',
                'slug' => '3-1',
                'type' => 'default',
                '_lft' => 20,
                '_rgt' => 21,
                'parent_id' => 10,
                'created_at' => '2019-02-08 14:42:16',
                'updated_at' => '2019-02-08 14:43:34',
                'value' => '3',
            ),
            11 => 
            array (
                'id' => 15,
                'name' => 'Hotel catering',
                'slug' => 'hotel-catering',
                'type' => 'default',
                '_lft' => 23,
                '_rgt' => 34,
                'parent_id' => NULL,
                'created_at' => '2019-02-08 14:44:03',
                'updated_at' => '2019-02-08 15:20:55',
                'value' => 'catering',
            ),
            12 => 
            array (
                'id' => 16,
                'name' => 'Without Pension',
                'slug' => 'without-pension',
                'type' => 'default',
                '_lft' => 24,
                '_rgt' => 25,
                'parent_id' => 15,
                'created_at' => '2019-02-08 14:59:10',
                'updated_at' => '2019-02-08 14:59:10',
                'value' => '1',
            ),
            13 => 
            array (
                'id' => 17,
                'name' => 'Breakfast',
                'slug' => 'breakfast',
                'type' => 'default',
                '_lft' => 26,
                '_rgt' => 27,
                'parent_id' => 15,
                'created_at' => '2019-02-08 14:59:22',
                'updated_at' => '2019-02-08 14:59:22',
                'value' => '2',
            ),
            14 => 
            array (
                'id' => 18,
                'name' => 'Half pension',
                'slug' => 'half-pension',
                'type' => 'default',
                '_lft' => 28,
                '_rgt' => 29,
                'parent_id' => 15,
                'created_at' => '2019-02-08 15:20:04',
                'updated_at' => '2019-02-08 15:20:04',
                'value' => '3',
            ),
            15 => 
            array (
                'id' => 19,
                'name' => 'Full board',
                'slug' => 'full-board',
                'type' => 'default',
                '_lft' => 30,
                '_rgt' => 31,
                'parent_id' => 15,
                'created_at' => '2019-02-08 15:20:22',
                'updated_at' => '2019-02-08 15:20:22',
                'value' => '4',
            ),
            16 => 
            array (
                'id' => 20,
                'name' => 'All inclusive',
                'slug' => 'all-inclusive',
                'type' => 'default',
                '_lft' => 32,
                '_rgt' => 33,
                'parent_id' => 15,
                'created_at' => '2019-02-08 15:20:37',
                'updated_at' => '2019-02-08 15:20:37',
                'value' => '5',
            ),
            17 => 
            array (
                'id' => 21,
                'name' => 'duration',
                'slug' => 'duration',
                'type' => 'default',
                '_lft' => 35,
                '_rgt' => 54,
                'parent_id' => NULL,
                'created_at' => '2019-02-08 16:11:13',
                'updated_at' => '2019-02-08 16:11:13',
                'value' => 'duration',
            ),
            18 => 
            array (
                'id' => 22,
                'name' => 'Exactly as indicated',
                'slug' => 'exactly-as-indicated',
                'type' => 'default',
                '_lft' => 36,
                '_rgt' => 37,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:12:51',
                'updated_at' => '2019-02-08 16:13:36',
                'value' => 'exact',
            ),
            19 => 
            array (
                'id' => 23,
                'name' => '1 Week',
                'slug' => '1-week',
                'type' => 'default',
                '_lft' => 38,
                '_rgt' => 39,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:15:50',
                'updated_at' => '2019-02-08 16:15:50',
                'value' => '7-',
            ),
            20 => 
            array (
                'id' => 24,
                'name' => '2 Weeks',
                'slug' => '2-weeks',
                'type' => 'default',
                '_lft' => 40,
                '_rgt' => 41,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:19:27',
                'updated_at' => '2019-02-08 16:19:27',
                'value' => '14-',
            ),
            21 => 
            array (
                'id' => 25,
                'name' => '3 Weeks',
                'slug' => '3-weeks',
                'type' => 'default',
                '_lft' => 42,
                '_rgt' => 43,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:20:24',
                'updated_at' => '2019-02-08 16:20:24',
                'value' => '21-',
            ),
            22 => 
            array (
                'id' => 26,
                'name' => '4 Weeks',
                'slug' => '4-weeks',
                'type' => 'default',
                '_lft' => 44,
                '_rgt' => 45,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:30:33',
                'updated_at' => '2019-02-08 16:30:33',
                'value' => '28-',
            ),
            23 => 
            array (
                'id' => 27,
                'name' => '1-4 Nights',
                'slug' => '1-4-nights',
                'type' => 'default',
                '_lft' => 46,
                '_rgt' => 47,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:30:57',
                'updated_at' => '2019-02-08 16:30:57',
                'value' => '1-4',
            ),
            24 => 
            array (
                'id' => 28,
                'name' => '5-8 Nights',
                'slug' => '5-8-nights',
                'type' => 'default',
                '_lft' => 48,
                '_rgt' => 49,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:31:17',
                'updated_at' => '2019-02-08 16:31:17',
                'value' => '5-8',
            ),
            25 => 
            array (
                'id' => 29,
                'name' => '9-12 Nights',
                'slug' => '9-12-nights',
                'type' => 'default',
                '_lft' => 50,
                '_rgt' => 51,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:31:32',
                'updated_at' => '2019-02-08 16:31:32',
                'value' => '9-12',
            ),
            26 => 
            array (
                'id' => 30,
                'name' => '13-15 Nights',
                'slug' => '13-15-nights',
                'type' => 'default',
                '_lft' => 52,
                '_rgt' => 53,
                'parent_id' => 21,
                'created_at' => '2019-02-08 16:31:48',
                'updated_at' => '2019-02-08 16:31:48',
                'value' => '13-15',
            ),
        ));
        
        
    }
}
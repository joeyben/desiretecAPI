<?php

namespace Modules\Whitelabels\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        foreach (config('whitelabels.layers', []) as $item) {
            if (!DB::table('layers')->where('name', $item['name'])->exists()) {
                DB::table('layers')->insertGetId([
                    'name'         => $item['name'],
                    'path'         => $item['path'],
                    'image'        => $item['image'],
                    'created_at'   => now(),
                    'updated_at'   => now()
                ]);
            }
        }
    }
}

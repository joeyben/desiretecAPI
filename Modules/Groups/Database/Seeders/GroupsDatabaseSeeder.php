<?php

namespace Modules\Groups\Database\Seeders;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Groups\Entities\Group;

class GroupsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $faker = \Faker\Factory::create();
        foreach (config('groups.permissions', []) as $key => $value) {
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

        $id = DB::table('groups')->insertGetId([
            'name'              => 'Tui Hamburg',
            'display_name'      => 'tui-hamburg',
            'description'       => $faker->sentence(100),
            'created_by'        => $faker->numberBetween(1, 3),
            'updated_by'        => $faker->numberBetween(1, 3),
            'whitelabel_id'     => 1,
            'current'           => 1,
            'created_at'        => DB::raw('now()'),
            'updated_at'        => DB::raw('now()'),
        ]);

        $user = Group::find($id);
        $user->users()->sync([$faker->numberBetween(5, 7)]);

        for ($i = 1; $i <= 100; ++$i) {
            $name = $faker->name;

            $id = DB::table('groups')->insertGetId([
                'name'              => $name,
                'display_name'      => str_slug($name),
                'description'       => $faker->sentence(100),
                'created_by'        => $faker->numberBetween(1, 3),
                'updated_by'        => $faker->numberBetween(1, 3),
                'whitelabel_id'     => $faker->numberBetween(1, 5),
                'created_at'        => DB::raw('now()'),
                'updated_at'        => DB::raw('now()'),
            ]);
            $user = Group::find($id);
            $user->users()->sync([$faker->numberBetween(5, 10)]);
        }
    }
}

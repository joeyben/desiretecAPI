<?php

use Faker\Generator;

$factory->define(\Modules\Groups\Entities\Group::class, function (Generator $faker) {

    return [
        'name'              => $faker->name,
        'display_name'      => $faker->name,
        'description'       => $faker->sentence(100),
        'created_by'        => $faker->numberBetween(1, 3),
        'updated_by'        => $faker->numberBetween(1, 3),
        'whitelabel_id'     => 1,
        'current'           => 1,
        'created_at'        => now(),
        'updated_at'        => now(),
    ];
});

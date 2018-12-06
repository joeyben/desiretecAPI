<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Wishes\Entities\Wish::class, function (Faker $faker) {
    return [
        'title'          => $faker->words(3),
        'featured_image' => $faker->imageUrl(),
        'description'    => $faker->sentence(10),
        'airport'        => $faker->words(3),
        'destination'    => $faker->city,
        'earliest_start' => $faker->date(),
        'latest_return'  => $faker->date(),
        'budget'         => $faker->numberBetween(1000, 3000),
        'adults'         => $faker->numberBetween(1, 5),
        'category'       => $faker->numberBetween(1, 5),
        'catering'       => $faker->words('3'),
        'duration'       => $faker->words(5),
        'created_by'     => $faker->numberBetween(1, 2),
        'updated_by'     => $faker->numberBetween(1, 2),
    ];
});

<?php

use App\Services\Flag\Src\Flag;

return [
    'name' => 'Whitelabels',

    'layers' => [
       0 => [
            'id' => Flag::PACKAGE,
            'name' => 'Package',
            'description' => 'Current default layer',
            'url' => 'https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png',
        ],
        1 => [
            'id' => Flag::FLIGHT,
            'name' => 'Flight',
            'description' => 'like travel overland',
            'url' => 'https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png',
        ],
        2 => [
            'id' => Flag::CRUISE,
            'name' => 'Cruise',
            'description' => 'like Kreuzfahrtberater',
            'url' => 'https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png',
        ]
    ]
];

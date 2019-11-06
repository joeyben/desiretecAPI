<?php

use App\Services\Flag\Src\Flag;

return [
    'name' => 'Whitelabels',

    'layers' => [
       0 => [
            'id'          => Flag::PACKAGE,
            'name'        => 'Package',
            'description' => 'Current default layer',
            'url'         => 'https://desiretec.s3.eu-central-1.amazonaws.com/img/uploads/Layer/default_picture_layer.png',
        ],
        1 => [
            'id'          => Flag::FLIGHT,
            'name'        => 'Flight',
            'description' => 'like travel overland',
            'url'         => 'https://desiretec.s3.eu-central-1.amazonaws.com/img/uploads/Layer/default_picture_layer.png',
        ],
        2 => [
            'id'          => Flag::CRUISE,
            'name'        => 'Cruise',
            'description' => 'like Kreuzfahrtberater',
            'url'         => 'https://desiretec.s3.eu-central-1.amazonaws.com/img/uploads/Layer/default_picture_layer.png',
        ]
    ]
];

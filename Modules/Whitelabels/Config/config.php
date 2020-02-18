<?php

use App\Services\Flag\Src\Flag;

return [
    'name' => 'Whitelabels',

    'layers' => [
       0 => [
            'id'          => Flag::PACKAGE,
            'name'        => 'Package',
            'path'        => 'package',
            'image'       => 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/layers/pic_layer_package.png',
        ],
        1 => [
            'id'          => Flag::FLIGHT,
            'name'        => 'Flight',
            'path'        => 'flight',
            'image'       => 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/layers/pic_layer_flight.png',
        ],
        2 => [
            'id'          => Flag::CRUISE,
            'name'        => 'Cruise',
            'path'        => 'cruise',
            'image'       => 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/layers/pic_layer_cruise.png',
        ],
        3 => [
            'id'          => Flag::HOTEL,
            'name'        => 'Hotel',
            'path'        => 'hotel',
            'image'       => 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/layers/pic_layer_hotel.png',
        ]
    ]
];

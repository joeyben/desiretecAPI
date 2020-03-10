<?php

return [
    'name'                 => 'Traveloverland',
    'id'                   => env('TRAVELOVERLAND_ID', 64),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_traveloverland',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'travel-overland.com',
    'development_url'      => 'travel-overland.reise-wunsch.com',
    'production_url'       => 'travel-overland.reisewunschservice.de',
];

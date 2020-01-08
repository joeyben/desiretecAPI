<?php

return [
    'name'                 => 'Bild',
    'id'                   => env('BILD_ID', 63),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_bild',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'https://bild.com',
    'development_url'      => 'https://bild.reise-wunsch.com',
    'production_url'       => 'https://bild.reisewunschservice.de',
];

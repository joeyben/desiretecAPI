<?php

return [
    'name' => 'Olimar',
    'id'   => env('OLIMAR_ID', 219),
    'locale' => 'de',
    'language_lines_table' => 'language_lines_olimar',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url' => 'https://olimar.com',
    'development_url' => 'https://olimar.reise-wunsch.com',
    'production_url' => 'https://olimar.reisewunschservice.de',
];

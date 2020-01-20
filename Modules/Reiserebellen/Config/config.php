<?php

return [
    'name'                 => 'Reiserebellen',
    'id'                   => env('REISEREBELLEN_ID', 67),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_reiserebellen',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'reiserebellen.com',
    'development_url'      => 'reiserebellen.reise-wunsch.com',
    'production_url'       => 'reiserebellen.reisewunschservice.de',
];

<?php

return [
    'name'                 => 'Reiserebellen',
    'id'                   => env('REISEREBELLEN_ID', 67),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_reiserebellen',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'reise-rebellen.com',
    'development_url'      => 'reise-rebellen.reise-wunsch.com',
    'production_url'       => 'reise-rebellen.reisewunschservice.de',
];

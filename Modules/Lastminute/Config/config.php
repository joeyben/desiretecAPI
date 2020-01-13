<?php

return [
    'name'                 => 'Lastminute',
    'id'                   => env('LASTMINUTE_ID', 87),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_lastminute',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'lastminute.com',
    'development_url'      => 'lastminute.reise-wunsch.com',
    'production_url'       => 'lastminute.reisewunschservice.de',
];

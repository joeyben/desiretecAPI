<?php

return [
    'name'                 => 'DkFerien',
    'id'                   => env('DKFERIEN_ID', 227),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_dkferien',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'http://dk-ferien.com',
    'development_url'      => 'https://dk-ferien.reise-wunsch.com',
    'production_url'       => 'https://dk-ferien.reisewunschservice.de',
];

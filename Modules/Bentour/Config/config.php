<?php

return [
    'name' => 'Bentour',
    'id'   => env('BENTOUR_ID', 206),
    'locale' => 'de',
    'language_lines_table' => 'language_lines_bentour',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url' => 'bentour.com',
    'development_url' => 'bentour.reise-wunsch.com',
    'production_url' => 'bentour.reisewunschservice.de',
];

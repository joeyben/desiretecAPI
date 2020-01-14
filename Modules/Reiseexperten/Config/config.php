<?php

return [
    'name'                 => 'Reiseexperten',
    'id'                   => env('REISEEXPERTEN_ID', 148),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_reiseexperten',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'reiseexperten.com',
    'development_url'      => 'reiseexperten.reise-wunsch.com',
    'production_url'       => 'reiseexperten.reisewunschservice.de',
];

<?php

return [
    'name'                 => 'Novasol',
    'id'                   => env('NOVASOL_ID', 50),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_novasol',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'http://novasol.com',
    'development_url'      => 'https://novasol.reise-wunsch.com',
    'production_url'       => 'https://novasol.reisewunschservice.de',
];

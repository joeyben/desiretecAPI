<?php

return [
    'name'                 => 'Test',
    'id'                   => env('TEST_ID', 202),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_test',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'http://test.local',
    'development_url'      => 'https://test.reise-wunsch.com',
    'production_url'       => 'https://test.reisewunschservice.de',
];

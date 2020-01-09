<?php

return [
    'name'                 => 'Master',
    'id'                   => env('MASTER_ID', 9),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_master',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'master.com',
    'development_url'      => 'master.reise-wunsch.com',
    'production_url'       => 'master.reisewunschservice.de',
];

<?php

return [
    'name'                 => 'DesiretecDemo',
    'id'                   => env('DESIRETECDEMO_ID', 167),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_desiretecdemo',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'https://desiretecdemo.com',
    'development_url'      => 'https://desiretecdemo.reise-wunsch.com',
    'production_url'       => 'https://desiretecdemo.reisewunschservice.de',
];

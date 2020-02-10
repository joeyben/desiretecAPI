<?php

return [
    'name' => 'Trendtours',
    'id'   => env('$MODULEID$', 39),
    'locale' => 'de',
    'language_lines_table' => 'language_lines_trendtours',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url' => 'https://trendtours.com',
    'development_url' => 'https://trendtours.reise-wunsch.com',
    'production_url' => 'https://trendtours.reisewunschservice.de',
];

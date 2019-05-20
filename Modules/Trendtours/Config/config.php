<?php

return [
    'name' => 'Trendtours',
    'id'   => 39,
    'locale' => 'de',
    'url' => 'https://trendtours.'.\Config('APP_ENV_URL'),
    'language_lines_table' => 'language_lines_trendtours',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class
];

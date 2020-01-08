<?php

return [
    'name'                 => 'Tui',
    'id'                   => env('TUI_ID', 156),
    'locale'               => 'de',
    'language_lines_table' => 'language_lines_tui',
    'language_lines_model' => \Modules\LanguageLines\Entities\LanguageLines::class,
    'local_url'            => 'tui.com',
    'development_url'      => 'tui.reise-wunsch.com',
    'production_url'       => 'tui.reisewunschservice.de',
];

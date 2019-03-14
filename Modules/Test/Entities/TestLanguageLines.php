<?php

namespace Modules\Test\Entities;

use Modules\LanguageLines\Entities\LanguageLines;

class TestLanguageLines extends LanguageLines
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language_lines_test';

    public static $whitelabel = 'test';
}
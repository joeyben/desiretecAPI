<?php

namespace Modules\Master\Entities;

use Modules\LanguageLines\Entities\LanguageLines;

class MasterLanguageLines extends LanguageLines
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language_lines_master';

    public static $whitelabel = 'master';
}
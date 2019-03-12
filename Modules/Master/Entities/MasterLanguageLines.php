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

    // TODO: change to master table
    protected $table = 'language_lines_tui';

    public static $whitelabel = 'master';
}
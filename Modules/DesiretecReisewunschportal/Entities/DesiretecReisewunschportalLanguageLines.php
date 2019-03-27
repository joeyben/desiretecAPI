<?php

namespace Modules\DesiretecReisewunschportal\Entities;

use Modules\LanguageLines\Entities\LanguageLines;

class DesiretecReisewunschportalLanguageLines extends LanguageLines
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language_lines_$SLUG$';

    public static $whitelabel = '$SLUG$';
}
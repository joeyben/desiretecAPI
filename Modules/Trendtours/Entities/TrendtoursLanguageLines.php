<?php

namespace Modules\Trendtours\Entities;

use Modules\LanguageLines\Entities\LanguageLines;

class TrendtoursLanguageLines extends LanguageLines
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language_lines_trendtours';

    public static $whitelabel = 'trendtours';
}

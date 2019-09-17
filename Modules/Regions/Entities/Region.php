<?php

namespace Modules\Regions\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Region extends Model
{
    use SoftDeletes;
    use SearchableTrait;
    use LogsActivity;

    protected $table = 'Regions';

    protected $guarded = [];

    protected static $logAttributes = [
        'region_code',
        'region_name',
        'country_code',
        'type'
    ];

    protected static $logOnlyDirty = true;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /*
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'Regions.id'                         => 10,
            'Regions.region_code'                       => 10,
            'Regions.region_name'               => 10,
            'Regions.country_code'               => 10,
        ]
    ];
}

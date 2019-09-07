<?php

namespace Modules\Rules\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Rule extends Model
{
    use SoftDeletes, SearchableTrait, LogsActivity;

    protected $guarded = [];

    protected static $logAttributes = [
        'type',
        'budget',
        'destinations'
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
            'rules.id'                         => 10,
            'rules.type'                       => 10,
            'rules.destinations'               => 10,
        ],
        'joins' => [
            'users'       => ['rules.user_id', 'users.id'],
            'whitelabels' => ['rules.whitelabel_id', 'whitelabels.id'],
        ]
    ];
}

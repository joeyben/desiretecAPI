<?php

namespace Modules\Wishes\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Wish extends Model
{
    use SoftDeletes, SearchableTrait;

    protected $guarded = [];

    protected $casts = [
        'status'  => 'boolean',
    ];

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
            'wishes.title'          => 10,
            'wishes.description'    => 10,
            'wishes.airport'        => 5,
            'wishes.destination'    => 5,
            'wishes.earliest_start' => 5,
            'wishes.latest_return'  => 5,
            'wishes.budget'         => 5,
            'wishes.adults'         => 5,
            'wishes.kids'           => 5,
            'wishes.catering'       => 5,
            'wishes.duration'       => 5
        ]
    ];
}

<?php

namespace Modules\Footers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Whitelabels\Entities\Whitelabel;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Footer extends Model
{
    use SoftDeletes;
    use SearchableTrait;
    use LogsActivity;

    protected $guarded = [];

    protected static $logAttributes = [
        'name',
        'url',
        'position',
        'whitelabel_id'
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
            'footers.id'               => 10,
            'footers.name'             => 10,
            'footers.url'              => 10,
            'footers.position'         => 10,
            'whitelabels.display_name' => 10,
        ],
        'joins' => [
            'whitelabels' => ['footers.whitelabel_id', 'whitelabels.id'],
        ]
    ];

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(Whitelabel::class);
    }
}

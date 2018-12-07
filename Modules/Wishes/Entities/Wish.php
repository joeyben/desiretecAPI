<?php

namespace Modules\Wishes\Entities;

use App\Models\Groups\Group;
use App\Models\Whitelabels\Whitelabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Wish extends Model
{
    use SoftDeletes, SearchableTrait, LogsActivity;

    protected $guarded = [];

    protected static $logAttributes = [
        'title',
        'featured_image',
        'description',
        'airport',
        'destination',
        'earliest_start',
        'latest_return',
        'budget',
        'adults',
        'kids',
        'category',
        'catering',
        'duration',
        'status',
        'created_by',
        'group_id',
        'updated_by',
        'whitelabel_id',
    ];

    protected static $logOnlyDirty = true;

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

    /**
     * Wishes belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Wishes belongsTo with Group.
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(Whitelabel::class);
    }
}

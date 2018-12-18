<?php

namespace Modules\Groups\Entities;

use App\Models\Access\User\User;
use App\Models\Whitelabels\Whitelabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use SoftDeletes, SearchableTrait, LogsActivity;

    protected $guarded = [];

    protected static $logAttributes = [
        'name',
        'display_name',
        'description',
        'status',
        'current'
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
            'groups.id'                         => 10,
            'groups.name'                       => 10,
            'groups.display_name'               => 10,
            'users.first_name'                  => 10,
            'users.last_name'                   => 10,
            'users.email'                       => 10,
            'whitelabels.name'                  => 10,
            'whitelabels.display_name'          => 10,
        ],
        'joins' => [
            'users'       => ['groups.created_by', 'users.id'],
            'whitelabels' => ['groups.whitelabel_id', 'whitelabels.id'],
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
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(Whitelabel::class);
    }
}

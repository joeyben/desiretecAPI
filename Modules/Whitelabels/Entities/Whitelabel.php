<?php

namespace Modules\Whitelabels\Entities;

use App\Models\Distributions\Distribution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Modules\Attachments\Traits\AttachableTrait;
use Modules\Languages\Entities\Language;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Whitelabel extends Model
{
    use SoftDeletes, SearchableTrait, LogsActivity, AttachableTrait;

    protected $fillable = ['name', 'display_name', 'status', 'domain', 'created_by', 'distribution_id', 'ga_view_id', 'state'];

    protected static $logAttributes = [
        'name',
        'display_name',
        'status',
        'created_by',
        'distribution_id',
        'ga_view_id',
        'state',
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
            'whitelabels.id'                         => 10,
            'whitelabels.name'                       => 10,
            'whitelabels.display_name'               => 10,
            'whitelabels.domain'                     => 10,
            'users.first_name'                       => 10,
            'users.last_name'                        => 10,
            'users.email'                            => 10,
            'distributions.name'                     => 10,
            'distributions.display_name'             => 10,
        ],
        'joins' => [
            'users'         => ['whitelabels.created_by', 'users.id'],
            'distributions' => ['whitelabels.distribution_id', 'distributions.id'],
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
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'whitelabel_user', 'whitelabel_id', 'user_id');
    }

    /**
     * get the wishes for a Whitelabel.
     */
    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    /**
     * get languages(locales) for a Whitelabel.
     */
    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    /**
     * get the distribution for a Whitelabel.
     */
    public function distribution()
    {
        return $this->hasOne(Distribution::class, 'id', 'distribution_id');
    }
}

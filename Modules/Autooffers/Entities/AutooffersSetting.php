<?php

namespace Modules\Autooffers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Modules\Whitelabels\Entities\Whitelabel;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class AutooffersSetting extends Model
{
    use SoftDeletes;
    use SearchableTrait;
    use LogsActivity;

    protected $guarded = [];

    protected static $logAttributes = [
        'display_offer',
        'recommendation',
        'price',
        'price_loop',
        'hotel_loop',
    ];

    protected static $logOnlyDirty = true;

    protected $casts = [
        'status'   => 'boolean'
    ];

    /**
     * Searchable autooffers_settings.
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
            'autooffers_settings.id'                         => 10,
            'autooffers_settings.display_offer'              => 10,
            'autooffers_settings.recommendation'             => 10,
            'autooffers_settings.rating'                     => 10,
            'autooffers_settings.price'                      => 10,
            'autooffers_settings.price_loop'                 => 10,
            'autooffers_settings.hotel_loop'                 => 10,
        ],
        'joins' => [
            'users'       => ['autooffers_settings.user_id', 'users.id'],
            'whitelabels' => ['autooffers_settings.whitelabel_id', 'whitelabels.id'],
        ]
    ];

    /**
     * Wishes belongsTo with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->hasOne(Whitelabel::class);
    }
}

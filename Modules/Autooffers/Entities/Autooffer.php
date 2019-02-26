<?php

namespace Modules\Autooffers\Entities;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wishes\Entities\Wish;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Autooffer extends Model
{
    use SoftDeletes, SearchableTrait, LogsActivity;

    protected $guarded = [];

    protected static $logAttributes = [
        'code',
        'type',
        'personPrice',
        'totalPrice',
        'from',
        'to',
        'tourOperator_code',
        'tourOperator_name',
        'hotel_code',
        'hotel_name',
        'hotel_location_name',
        'hotel_location_lng',
        'hotel_location_lat',
        'hotel_location_region_code',
        'hotel_location_region_name',
        'airport_code',
        'airport_name',
        'wish_id',
        'user_id',
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
            'autooffers.id'                         => 10,
            'autooffers.from'                       => 10,
            'autooffers.to'                         => 10,
            'autooffers.totalPrice'                 => 10,
            'autooffers.hotel_location_name'        => 10,
            'autooffers.hotel_location_region_name' => 10,
            'autooffers.airport_name'               => 10,
            'wishes.id'                             => 10,
            'users.id'                              => 10,
        ],
        'joins' => [
            'users'       => ['autooffers.user_id', 'users.id'],
            'wishes'      => ['autooffers.wish_id', 'wishes.id'],
        ]
    ];

    /**
     * Autooffers belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Wishes belongsTo with Wish.
     */
    public function wish()
    {
        return $this->belongsTo(Wish::class);
    }
}

<?php

namespace Modules\Notifications\Entities;

use App\Models\Access\User\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Notification extends Model
{
    use SearchableTrait, SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'notifications.id' => 10,
            'notifications.message' => 10
        ]
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('c');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

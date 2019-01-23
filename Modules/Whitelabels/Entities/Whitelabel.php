<?php

namespace Modules\Whitelabels\Entities;

use App\Models\Distributions\Distribution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Whitelabel extends Model
{
    use SoftDeletes, SearchableTrait, LogsActivity;

    protected $fillable = ['name', 'display_name', 'status', 'domain', 'created_by', 'distribution_id', 'bg_image', 'logo_image', 'state'];

    protected static $logAttributes = [
        'name',
        'display_name',
        'status',
        'created_by',
        'distribution_id',
        'bg_image',
        'state',
    ];

    protected static $logOnlyDirty = true;

    protected $casts = [
        'status'  => 'boolean',
    ];

    /**
     * Wishes belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Wishes belongsTo with User.
     */
    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }
}

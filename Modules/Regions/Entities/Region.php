<?php

namespace Modules\Regions\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Region extends Model
{
    use SoftDeletes;
    use SearchableTrait;
    use LogsActivity;

    protected $table = 'Regions';

    protected $guarded = [];

    protected static $logAttributes = [
        'region_code',
        'region_name',
        'country_code',
        'type'
    ];

    protected static $logOnlyDirty = true;
}

<?php

namespace Modules\Variants\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Whitelabels\Entities\Layer;
use Modules\Whitelabels\Entities\LayerWhitelabel;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Variant extends Model
{
    use SoftDeletes;
    use SearchableTrait;
    use LogsActivity;

    protected $guarded = [];

    protected static $logOnlyDirty = true;


    public function layer()
    {
        return $this->belongsTo(LayerWhitelabel::class);
    }
}

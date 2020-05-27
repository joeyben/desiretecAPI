<?php

namespace Modules\Whitelabels\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Attachments\Traits\AttachableTrait;
use Modules\Variants\Entities\Variant;
use Spatie\Activitylog\Traits\LogsActivity;

class LayerWhitelabel extends Pivot
{
    use AttachableTrait;

    use LogsActivity;

    protected $guarded = [];

    protected static $logOnlyDirty = true;

    public function layer()
    {
        return $this->belongsTo(Layer::class);
    }

    public function whitelabel()
    {
        return $this->belongsTo(Whitelabel::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'layer_whitelabel_id');
    }
}

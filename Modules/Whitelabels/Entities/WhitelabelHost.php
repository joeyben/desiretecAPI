<?php

namespace Modules\Whitelabels\Entities;

use Illuminate\Database\Eloquent\Model;

class WhitelabelHost extends Model
{

    protected $guarded = [];

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(Whitelabel::class);
    }

}

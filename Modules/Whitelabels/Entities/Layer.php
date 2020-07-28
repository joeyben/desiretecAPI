<?php

namespace Modules\Whitelabels\Entities;

use Illuminate\Database\Eloquent\Model;

class Layer extends Model
{
    protected $guarded = [];

    public function hosts()
    {
        return $this->hasMany(WhitelabelHost::class);
    }
}

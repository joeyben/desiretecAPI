<?php

namespace Modules\Languages\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Whitelabels\Entities\Whitelabel;
use Nicolaslopezj\Searchable\SearchableTrait;

class Language extends Model
{
    use SearchableTrait;
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    /**
     * Languages belongsTo with Whitelabel.
     */
    public function whitelabels()
    {
        return $this->belongsToMany(Whitelabel::class);
    }
}

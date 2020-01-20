<?php

namespace App\Models\Whitelabels\Traits\Relationship;

use App\Models\Distributions\Distribution;
use App\Models\Layers\WhitelableLayer;
use App\Models\Wishes\Wish;
use Modules\Attachments\Entities\Attachment;

/**
 * Class WhitelabelRelationship.
 */
trait WhitelabelRelationship
{
    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'whitelabel_user', 'whitelabel_id', 'user_id');
    }

    /**
     * get the wishes for a Whitelabel.
     */
    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    /**
     * get the distribution for a Whitelabel.
     */
    public function distribution()
    {
        return $this->hasOne(Distribution::class, 'id', 'distribution_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function whitelableLayer()
    {
        return $this->hasMany(WhitelableLayer::class);
    }
}

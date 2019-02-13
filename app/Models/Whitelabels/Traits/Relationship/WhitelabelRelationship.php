<?php

namespace App\Models\Whitelabels\Traits\Relationship;

use App\Models\Distributions\Distribution;
use App\Models\Wishes\Wish;

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
}

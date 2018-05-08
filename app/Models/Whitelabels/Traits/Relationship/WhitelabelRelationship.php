<?php

namespace App\Models\Whitelabels\Traits\Relationship;

use App\Models\Wishes\Wish;
use App\Models\Distributions\Distribution;

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
    public function whises()
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
<?php

namespace App\Models\Distributions\Traits\Relationship;

use App\Models\Wishes\Wish;

/**
 * Class DistributionRelationship.
 */
trait DistributionRelationship
{
    /**
     * Many-to-Many relations with Whitelabel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function whitelabels()
    {
        return $this->belongsToMany(config('access.whitelabel'), config('access.whitelabel_distribution_table'), 'distribution_id', 'whitelabel_id');
    }

}

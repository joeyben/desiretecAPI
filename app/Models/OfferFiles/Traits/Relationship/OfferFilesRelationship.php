<?php

namespace App\Models\Offers\Traits\Relationship;

use App\Models\Offers\Offer;

/**
 * Class OfferFilesRelationship.
 */
trait OfferFilesRelationship
{
    /**
     * Offers belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

}

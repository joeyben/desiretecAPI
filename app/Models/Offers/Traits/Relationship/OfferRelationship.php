<?php

namespace App\Models\Offers\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Wishes\Wish;
use App\Models\OfferFiles\OfferFile;

/**
 * Class OfferRelationship.
 */
trait OfferRelationship
{
    /**
     * Offers belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Offers belongsTo with Wish.
     */
    public function wish()
    {
        return $this->belongsTo(Wish::class, 'wish_id');
    }

    /**
     * Offers HasMany  OfferFiles.
     */
    public function offerFiles()
    {
        return $this->hasMany(OfferFile::class, 'offer_id', 'id');
    }
}

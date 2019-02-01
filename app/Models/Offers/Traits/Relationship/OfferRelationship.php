<?php

namespace App\Models\Offers\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Wishes\Wish;

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

    /*
     * Offers belongsTo with Agent.
     */
    // public function agent()
    // {
    //     return $this->belongsTo(Agent::class, 'agent_id');
    // }
}

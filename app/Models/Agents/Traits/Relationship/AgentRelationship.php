<?php

namespace App\Models\Agents\Traits\Relationship;

/**
 * Class AgentRelationship.
 */
trait AgentRelationship
{
    /**
     * get the distribution for a Agent.
     */
    public function user()
    {
        return $this->hasOne(config('auth.providers.users.model'), 'id', 'user_id');
    }

    /*
     * Agents have many Offers.
     */
    // public function offers()
    // {
    //     return $this->hasMany(Offer::class);
    // }
}

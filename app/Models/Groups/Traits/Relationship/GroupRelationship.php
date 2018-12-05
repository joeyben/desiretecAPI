<?php

namespace App\Models\Groups\Traits\Relationship;

use App\Models\Access\User\User;

/**
 * Class GroupRelationship.
 */
trait GroupRelationship
{
    /**
     * Groups belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Groups belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(config('access.whitelabel'));
    }

    /**
     * Groups belongsTo many Users.
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'group_user', 'group_id', 'user_id');
    }
}

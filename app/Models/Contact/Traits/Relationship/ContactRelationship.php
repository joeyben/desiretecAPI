<?php

namespace App\Models\Contact\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Wishes\Wish;
use App\Models\Groups\Group;

/**
 * Class ContactRelationship.
 */
trait ContactRelationship
{
    /**
     * Contact belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Contact belongsTo Wish.
     */
    public function wish()
    {
        return $this->belongsTo(Wish::class, 'wish_id');
    }

    /**
     * Contact belongsTo Group.
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

}

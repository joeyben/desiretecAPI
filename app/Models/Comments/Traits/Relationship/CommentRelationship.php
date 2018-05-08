<?php

namespace App\Models\Comments\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Offers\Offer;

/**
 * Class CommentRelationship.
 */
trait CommentRelationship
{

    /**
     * Comments belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}

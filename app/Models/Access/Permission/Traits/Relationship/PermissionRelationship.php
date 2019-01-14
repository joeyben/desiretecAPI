<?php

namespace App\Models\Access\Permission\Traits\Relationship;

use App\Models\Access\User\User;

/**
 * Class PermissionRelationship.
 */
trait PermissionRelationship
{
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.permission_role_table'), 'permission_id', 'role_id');
    }

    /**
     * Wishes belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

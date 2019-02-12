<?php

namespace Modules\Groups\Policies;

use App\Models\Access\User\User;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Groups\Entities\Group;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Access\User\User $user
     * @param                              $ability
     *
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the group.
     *
     * @param \App\Models\Access\User\User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view-group');
    }

    /**
     * Determine whether the user can create groupes.
     *
     * @param \App\Models\Access\User\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create-group');
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param \App\Models\Access\User\User   $user
     * @param \Modules\Groups\Entities\Group $group
     *
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        return $user->hasPermission('update-group');
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param \App\Models\Access\User\User   $user
     * @param \Modules\Groups\Entities\Group $group
     *
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        return $user->hasPermission('delete-group');
    }

    /**
     * Determine whether the user can restore the group.
     *
     * @param \App\Models\Access\User\User   $user
     * @param \Modules\Groups\Entities\Group $group
     *
     * @return mixed
     */
    public function restore(User $user, Group $group)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the group.
     *
     * @param \App\Models\Access\User\User $user
     *
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return false;
    }
}

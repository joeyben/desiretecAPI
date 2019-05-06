<?php

namespace Modules\Wishes\Policies;

use App\Models\Access\User\User;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Wishes\Entities\Wish;

class WishPolicy
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
     * Determine whether the user can view the wish.
     *
     * @param \App\Models\Access\User\User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view-wish');
    }

    /**
     * Determine whether the user can create wishes.
     *
     * @param \App\Models\Access\User\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create-wish');
    }

    /**
     * Determine whether the user can update the wish.
     *
     * @param \App\Models\Access\User\User  $user
     * @param \Modules\Wishes\Entities\Wish $wish
     *
     * @return mixed
     */
    public function update(User $user, Wish $wish)
    {
        return $user->hasPermission('update-wish') || ((int) $user->id === (int) $wish->created_by);
    }

    /**
     * Determine whether the user can delete the wish.
     *
     * @param \App\Models\Access\User\User  $user
     * @param \Modules\Wishes\Entities\Wish $wish
     *
     * @return mixed
     */
    public function delete(User $user, Wish $wish)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the wish.
     *
     * @param \App\Models\Access\User\User  $user
     * @param \Modules\Wishes\Entities\Wish $wish
     *
     * @return mixed
     */
    public function restore(User $user, Wish $wish)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the wish.
     *
     * @param \App\Models\Access\User\User  $user
     * @param \Modules\Wishes\Entities\Wish $wish
     *
     * @return mixed
     */
    public function forceDelete(User $user, Wish $wish)
    {
        return false;
    }
}

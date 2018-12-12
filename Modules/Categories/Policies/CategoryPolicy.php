<?php

namespace Modules\Categories\Policies;

use App\Models\Access\User\User;
use BrianFaust\Categories\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\Access\User\User          $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view-category');
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\Access\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create-category');
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\Access\User\User          $user
     * @param \BrianFaust\Categories\Models\Category $category
     *
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
        return $user->hasPermission('update-category');
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\Access\User\User          $user
     * @param \BrianFaust\Categories\Models\Category $category
     *
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
        return $user->hasPermission('delete-category');
    }

    /**
     * Determine whether the user can restore the category.
     *
     * @param  \App\Models\Access\User\User          $user
     * @param \BrianFaust\Categories\Models\Category $category
     *
     * @return mixed
     */
    public function restore(User $user, Category $category)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the category.
     *
     * @param  \App\Models\Access\User\User          $user
     * @param \BrianFaust\Categories\Models\Category $category
     *
     * @return mixed
     */
    public function forceDelete(User $user, Category $category)
    {
        return false;
    }
}

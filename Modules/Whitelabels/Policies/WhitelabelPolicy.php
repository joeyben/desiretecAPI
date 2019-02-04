<?php

namespace Modules\Whitelabels\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class WhitelabelPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }
}

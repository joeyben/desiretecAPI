<?php

namespace Modules\Wishes\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Wishes\Entities\Wish;
use Modules\Wishes\Policies\WishPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Wish::class => WishPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}

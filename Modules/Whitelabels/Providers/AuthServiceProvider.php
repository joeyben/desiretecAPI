<?php

namespace Modules\Whitelabels\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Whitelabels\Entities\Whitelabel;
use Modules\Whitelabels\Policies\WhitelabelPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Whitelabel::class => WhitelabelPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}

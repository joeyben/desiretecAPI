<?php

namespace Modules\Dashboard\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Dashboard\Entities\Dashboard;
use Modules\Dashboard\Policies\DashboardPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Dashboard::class => DashboardPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}

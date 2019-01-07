<?php

namespace Modules\Roles\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Roles\Repositories\Contracts\RolesRepository;
use Modules\Roles\Repositories\Eloquent\EloquentRolesRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->app->bind(RolesRepository::class, EloquentRolesRepository::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

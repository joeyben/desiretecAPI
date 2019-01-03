<?php

namespace Modules\Permissions\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Permissions\Repositories\Contracts\PermissionsRepository;
use Modules\Permissions\Repositories\Eloquent\EloquentPermissionsRepository;

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
        $this->app->bind(PermissionsRepository::class, EloquentPermissionsRepository::class);
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

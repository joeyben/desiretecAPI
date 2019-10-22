<?php

namespace Modules\Regions\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Regions\Repositories\Contracts\RegionsRepository;
use Modules\Regions\Repositories\Eloquent\EloquentRegionsRepository;

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
        $this->app->bind(RegionsRepository::class, EloquentRegionsRepository::class);
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

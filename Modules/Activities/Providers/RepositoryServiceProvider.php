<?php

namespace Modules\Activities\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Activities\Repositories\Eloquent\EloquentActivitiesRepository;

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
        $this->app->bind(ActivitiesRepository::class, EloquentActivitiesRepository::class);
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

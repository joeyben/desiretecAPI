<?php

namespace Modules\Agents\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Agents\Repositories\Contracts\AgentsRepository;
use Modules\Agents\Repositories\Eloquent\EloquentAgentsRepository;

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
        $this->app->bind(AgentsRepository::class, EloquentAgentsRepository::class);
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

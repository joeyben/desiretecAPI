<?php

namespace Modules\Groups\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Groups\Repositories\Contracts\GroupsRepository;
use Modules\Groups\Repositories\Eloquent\EloquentGroupsRepository;

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
        $this->app->bind(GroupsRepository::class, EloquentGroupsRepository::class);
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

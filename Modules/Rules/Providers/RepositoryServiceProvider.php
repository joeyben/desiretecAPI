<?php

namespace Modules\Rules\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Rules\Repositories\Contracts\RulesRepository;
use Modules\Rules\Repositories\Eloquent\EloquentRulesRepository;

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
        $this->app->bind(RulesRepository::class, EloquentRulesRepository::class);
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

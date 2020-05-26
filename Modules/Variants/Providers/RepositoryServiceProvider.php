<?php

namespace Modules\Variants\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Agents\Repositories\Contracts\VariantsRepository;
use Modules\Variants\Repositories\Eloquent\EloquentVariantsRepository;

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
        $this->app->bind(VariantsRepository::class, EloquentVariantsRepository::class);
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

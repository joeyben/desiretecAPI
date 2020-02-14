<?php

namespace Modules\Whitelabels\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Whitelabels\Repositories\Contracts\LayersRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;
use Modules\Whitelabels\Repositories\Eloquent\EloquentLayersRepository;
use Modules\Whitelabels\Repositories\Eloquent\EloquentWhitelabelsRepository;

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
        $this->app->bind(WhitelabelsRepository::class, EloquentWhitelabelsRepository::class);
        $this->app->bind(LayersRepository::class, EloquentLayersRepository::class);
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

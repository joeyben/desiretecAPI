<?php

namespace Modules\Footers\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Footers\Repositories\Contracts\FootersRepository;
use Modules\Footers\Repositories\Eloquent\EloquentFootersRepository;

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
        $this->app->bind(FootersRepository::class, EloquentFootersRepository::class);
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

<?php

namespace Modules\Wishes\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Wishes\Repositories\Contracts\WishesRepository;
use Modules\Wishes\Repositories\Eloquent\EloquentWishesRepository;

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
        $this->app->bind(WishesRepository::class, EloquentWishesRepository::class);
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

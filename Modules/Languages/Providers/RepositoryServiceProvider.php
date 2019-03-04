<?php

namespace Modules\Languages\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;
use Modules\Languages\Repositories\Eloquent\EloquentLanguagesRepository;

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
        $this->app->bind(LanguagesRepository::class, EloquentLanguagesRepository::class);
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

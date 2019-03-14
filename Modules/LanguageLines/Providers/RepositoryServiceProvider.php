<?php

namespace Modules\LanguageLines\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;
use Modules\LanguageLines\Repositories\Eloquent\EloquentLanguageLinesRepository;

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
        $this->app->bind(LanguageLinesRepository::class, EloquentLanguageLinesRepository::class);
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

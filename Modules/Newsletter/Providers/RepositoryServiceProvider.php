<?php

namespace Modules\Newsletter\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Newsletter\Repositories\Contracts\NewsletterRepository;
use Modules\Newsletter\Repositories\Eloquent\EloquentNewsletterRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(NewsletterRepository::class, EloquentNewsletterRepository::class);
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

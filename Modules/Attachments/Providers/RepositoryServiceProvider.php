<?php

namespace Modules\Attachments\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Attachments\Repositories\Contracts\AttachmentsRepository;
use Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository;

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
        $this->app->bind(AttachmentsRepository::class, EloquentAttachmentsRepository::class);
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

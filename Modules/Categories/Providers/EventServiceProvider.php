<?php

namespace Modules\Categories\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Categories\Listeners\CategorySubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }

    protected $subscribe = [
        CategorySubscriber::class
    ];
}
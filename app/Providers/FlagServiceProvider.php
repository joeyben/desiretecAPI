<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FlagServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('App\Services\Flag\Interfaces\FlagInterface', 'App\Services\Flag\Src\Flag');
    }

    public function provides()
    {
        return ['App\Services\Flag\Interfaces\FlagInterface'];
    }
}

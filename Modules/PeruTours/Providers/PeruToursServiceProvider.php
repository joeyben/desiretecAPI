<?php

namespace Modules\PeruTours\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class PeruToursServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('perutours.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'perutours'
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/perutours');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/perutours';
        }, \Config::get('view.paths')), [$sourcePath]), 'perutours');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/perutours');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'perutours');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'perutours');
        }
    }

    /**
     * Register an additional directory of factories.
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
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

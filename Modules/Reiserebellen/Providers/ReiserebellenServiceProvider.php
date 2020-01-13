<?php

namespace Modules\Reiserebellen\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class ReiserebellenServiceProvider extends ServiceProvider
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
            __DIR__ . '/../Config/config.php' => config_path('reiserebellen.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            'reiserebellen'
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/reiserebellen');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/reiserebellen';
        }, \Config::get('view.paths')), [$sourcePath]), 'reiserebellen');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/reiserebellen');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'reiserebellen');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'reiserebellen');
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

<?php

namespace SaeedVaziry\LaravelSwagger;

use Illuminate\Support\ServiceProvider;
use SaeedVaziry\LaravelSwagger\Console\GenerateDocsCommand;

class LaravelSwaggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'laravel-swagger');

        // Publish a config file
        $configPath = __DIR__.'/../config/laravel-swagger.php';
        $this->publishes([
            $configPath => config_path('laravel-swagger.php'),
        ], 'config');

        //Include routes
        \Route::group(['namespace' => 'SaeedVaziry\LaravelSwagger'], function ($router) {
            require __DIR__.'/routes.php';
        });

        //Register commands
        $this->commands([GenerateDocsCommand::class]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/laravel-swagger.php';
        $this->mergeConfigFrom($configPath, 'laravel-swagger');

        $this->app->singleton('command.laravel-swagger.generate', function () {
            return new GenerateDocsCommand();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.laravel-swagger.generate',
        ];
    }
}

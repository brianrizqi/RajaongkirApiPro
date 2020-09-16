<?php

namespace Brianrizqi\RajaongkirPro;

use Brianrizqi\RajaongkirPro\Facades\RajaongkirPro;
use Illuminate\Support\ServiceProvider;

class RajaongkirProServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/rajaongkirpro.php', 'rajaongkirpro');

        // Register the service the package provides.
        $this->app->singleton('rajaongkirpro', function ($app) {
            return new RajaongkirPro;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['RajaongkirApiPro'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/rajaongkirpro.php' => config_path('rajaongkirpro.php'),
        ], 'rajaongkirpro.config');
    }
}

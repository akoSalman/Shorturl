<?php

namespace Ako\Shorturl;

use Illuminate\Support\ServiceProvider;

class ShorturlServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('shorturl', function ($app) {
            return resolve("Ako\Shorturl\Shorturl");
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/shorturl.php', 'shorturl');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/shorturl.php' => config_path('shorturl.php')
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }
}
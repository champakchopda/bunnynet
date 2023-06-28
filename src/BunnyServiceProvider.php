<?php

namespace Sevenspan\Bunny;

use Illuminate\Support\ServiceProvider;

class BunnyServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        $path = $this->mergeConfigFrom(__DIR__ . '/config/bunny.php', 'bunny');

        $this->app->bind('Bunny', function () {
            return new Bunny();
        });
    }


    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/bunny.php' => config_path('bunny.php'),
            ], 'config');
        }
    }
}

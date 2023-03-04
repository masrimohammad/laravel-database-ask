<?php

namespace Database\Ask\Providers;

use Database\Ask\DatabaseAsk;
use Illuminate\Support\ServiceProvider;

class DatabaseAskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(dirname(__DIR__, 1) . '/views', 'database-ask');

        $this->publishes([
            dirname(__DIR__, 1) . '/config/database-ask.php' => config_path('database-ask.php')
        ], 'database-ask');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(config('database-ask.name'), function () {
            return new DatabaseAsk();
        });
    }
}

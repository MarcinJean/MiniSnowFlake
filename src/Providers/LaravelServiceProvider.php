<?php

namespace MarcinJean\MiniSnowflake\Providers;

use MarcinJean\MiniSnowflake\MiniSnowflake;

class LaravelServiceProvider extends AbstractServiceProvider
{
    /**
     * Bootstrap any application services for laravel.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/minisnowflake.php' => config_path('minisnowflake.php'),
        ]);
    }
}
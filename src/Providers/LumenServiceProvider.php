<?php


namespace MarcinJean\MiniSnowflake\Providers;

class LumenServiceProvider extends AbstractServiceProvider
{
    /**
     * Bootstrap any application services for lumen.
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__ . '/../../config/minisnowflake.php');

        $this->mergeConfigFrom($path, 'minisnowflake');
    }
}
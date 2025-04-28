<?php

namespace MarcinJean\MiniSnowflake\Providers;

use Illuminate\Support\ServiceProvider;
use MarcinJean\MiniSnowflake\MiniSnowflake;

abstract class AbstractServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    abstract public function boot();

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MiniSnowflake::class, function () {
            $epoch = config('minisnowflake.epoch', null);
            $timestamp = $epoch === null ? null :  $timestamp = strtotime($epoch);
            return new MiniSnowflake($timestamp);
        });
    }
}
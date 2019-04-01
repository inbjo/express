<?php


namespace Flex\Express;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Express::class, function () {
            return new Express(config('services.express.id'), config('services.express.key'), config('services.express.type'));
        });

        $this->app->alias(Express::class, 'express');
    }

    public function provides()
    {
        return [Express::class, 'express'];
    }
}
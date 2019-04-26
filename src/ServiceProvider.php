<?php

/*
 * This file is part of the flex/express.
 *
 * (c) Flex<2345@mail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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

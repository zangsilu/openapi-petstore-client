<?php

/*
 * This file is part of the boqii openapi search client package.
 *
 * (c) qinjb <qinjb@boqii.com> liugj <liugj@boqii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bqrd\OpenApi\PetStore\Providers;

use Bqrd\OpenApi\PetStore\Order;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * defer.
     *
     * @var mixed
     */
    protected $defer = true;

    /**
     * register.
     *
     *
     *
     * @return mixed
     */
    public function register()
    {
        $this->app->singleton(Order::class, function ($app) {
            $app->configure('openapi-petstore-client');
            $config = $app->make('config')->get('openapi-petstore-client');

            return new Order($config['baseUri'], $config['options']);
        });
    }

    /**
     * provides.
     *
     *
     *
     * @return mixed
     */
    public function provides()
    {
        return [Order::class];
    }
}

<?php

/******************************************************************************
 * Copyright 2022, Hopex LP. All Rights Reserved                              *
 *                                                                            *
 * GitHub: https://github.com/H0pex                                           *
 *                                                                            *
 * @author      Schizo                                                        *
 * @site        https://vk.com/id244036703                                    *
 ******************************************************************************/

namespace Hopex\Simplog\Providers;

use Hopex\Simplog\Logger;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('logger', Logger::class);
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}

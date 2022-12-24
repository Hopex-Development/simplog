<?php

/******************************************************************************
 * Copyright 2022, Hopex LP. All Rights Reserved                              *
 *                                                                            *
 * GitHub: https://github.com/H0pex                                           *
 *                                                                            *
 * @author      Schizo                                                        *
 * @site        https://vk.com/id244036703                                    *
 ******************************************************************************/

namespace Hopex\Simplog\Facades;

use Illuminate\Support\Facades\Facade;

class Logger extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Hopex\Simplog\Logger::class;
    }
}

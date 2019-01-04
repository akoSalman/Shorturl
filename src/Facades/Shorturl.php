<?php

namespace Ako\Shorturl\Facades;

use Illuminate\Support\Facades\Facade;

class Shorturl extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shorturl';
    }

}

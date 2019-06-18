<?php

namespace MVC\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class DB
 *
 * @package MVC\Facades
 */
class DB extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}
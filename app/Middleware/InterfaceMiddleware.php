<?php

namespace MVC\Middleware;

/**
 * Interface InterfaceMiddleware
 * @package MVC\Middleware
 */
interface InterfaceMiddleware
{
    /**
     * InterfaceMiddleware constructor.
     * @param array $aData
     */
    public function __construct($aData = []);
    public function handle();
}

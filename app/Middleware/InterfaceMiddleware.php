<?php

namespace MVC\Middleware;

interface InterfaceMiddleware
{
    public function __construct($aData = []);
    public function handle();
}

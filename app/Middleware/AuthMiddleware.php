<?php

namespace MVC\Middleware;

use MVC\Support\Auth;
use MVC\Support\Redirect;
use MVC\Support\Session;

class AuthMiddleware implements InterfaceMiddleware
{
    public $aData;


    /**
     * AuthMiddleware constructor.
     *
     * @param array $aData
     */
    public function __construct($aData = [])
    {
        $this->aData = $aData;
        $this->handle();
    }

    public function handle()
    {
        if (!Auth::isLoggedIn()) {
            Redirect::to("user/login");
        }
        return true;
    }
}

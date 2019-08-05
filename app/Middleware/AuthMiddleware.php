<?php declare(strict_types=1);

namespace MVC\Middleware;

use MVC\Support\Auth;
use MVC\Support\Redirect;

/**
 * Class AuthMiddleware
 * @package MVC\Middleware
 */
class AuthMiddleware implements InterfaceMiddleware
{
    /**
     * @var array
     */
    public $aData;
    /**
     * AuthMiddleware constructor.
     * @param array $aData
     */
    public function __construct($aData = [])
    {
        $this->aData = $aData;
        $this->handle();
    }
    /**
     * @return bool
     */
    public function handle()
    {
        if (!Auth::isLoggedIn()) {
            Redirect::to("user/login");
        }
        return true;
    }
}

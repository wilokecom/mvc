<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 31/07/2019
 * Time: 11:44 SA
 */
namespace MVC\Middleware;

use MVC\Support\Auth;
use MVC\Support\Redirect;
use MVC\Support\Session;

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
        // TODO: Implement handle() method.
        if (!Auth::isLoggedIn()) {
            Redirect::to("user/login");
        }
        return true;
    }
}
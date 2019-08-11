<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 08/08/2019
 * Time: 3:24 CH
 */
namespace MVC\Support;

/**
 * Class Helper
 * @package MVC\Support
 */
class Helper
{
    public static function redirectToDashboard()
    {
        if (Auth::isLoggedIn()) {
            Redirect::to('user/dashboard');
        }
    }
}
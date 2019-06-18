<?php

namespace MVC\Support;
/**
 * Class Redirect
 *
 * @package MVC\Support
 */
class Redirect
{
    /**
     * @param $route
     *Điều hướng trang
     */
    public static function to($route)
    {
        //Điều hướng trang
        header('Location: ' . Route::get($route));//include fileapp/Support/Route.php
        exit();
    }
}

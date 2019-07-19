<?php

namespace MVC\Support;

/**
 * Class Redirect
 * @package MVC\Support
 */
class Redirect
{
    /**
     * @param $route
     * Page navigation
     * Include fileapp/Support/Route.php
     */
    public static function to($route)
    {
        header("Location: " . Route::get($route));
        exit();
    }
}

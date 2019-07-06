<?php declare(strict_types=1);

namespace MVC\Support;

/**
 * Class Redirect
 * @package MVC\Support
 */
class Redirect
{
    /**
     * @param $route
     */
    public static function to($route)
    {
        header("Location: " . Route::get($route));//include fileapp/Support/Route.php
        exit();
    }
}

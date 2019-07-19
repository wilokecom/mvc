<?php
namespace MVC\Support;

/**
 * Class Route
 * @package MVC\Support
 */
class Route
{
    /**
     * @return string
     * @param $route
     * return url
     */
    public static function get($route)
    {
        return MVC_HOME_URL . $route;
    }
}

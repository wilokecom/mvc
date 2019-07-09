<?php declare(strict_types=1);
namespace MVC\Support;

/**
 * Class Route
 * @package MVC\Support
 */
class Route
{
    /**
     * Get url link
     * @return string
     * @param $route
     */
    public static function get($route)
    {
        return MVC_HOME_URL . $route;
    }
}

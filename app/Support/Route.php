<?php

namespace MVC\Support;

class Route
{
    /**
     * @param $route String
     *
     * @return String
     */
    public static function get($route)
    {
        return MVC_HOME_URL . $route;
    }
}

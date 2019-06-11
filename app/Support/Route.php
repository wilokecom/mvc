<?php
namespace MVC\Support;

class Route
{
    /**
     * @param $route String
     *
     * @return String
     */
    //Trả về đường dẫn url
    public static function get($route)
    {
        return MVC_HOME_URL . $route;
    }
}

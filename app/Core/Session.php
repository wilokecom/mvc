<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 03/06/2019
 * Time: 11:17 SA
 */
namespace MVC\Core;

class Session
{
    public static function init()
    {
        session_start();
    }

    public static function set($key, $aValue)
    {
        $_SESSION[$key] = $aValue;
    }
    public static function get($key){
        if(isset($_SESSION[$key])) return $_SESSION[$key];
    }

    public static function destroy(){
        session_destroy();
    }
}

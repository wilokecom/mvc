<?php

namespace MVC\Support;

class Auth
{
    private static $sLoginSessionKey = 'user_logged_in';

    /**
     * Check logined or not
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Session::has(self::$sLoginSessionKey);
    }
}

<?php

namespace MVC\Support;

/**
 * Class Auth
 * @package MVC\Support
 */
class Auth
{
    /**
     * @var string
     */
    public static $sLoginSessionKey = 'user_logged_in';

    /**
     * Check logined or not
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Session::has(self::$sLoginSessionKey);
    }
}

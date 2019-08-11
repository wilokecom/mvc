<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 07/08/2019
 * Time: 5:59 CH
 */
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
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Session::has(self::$sLoginSessionKey);
    }
}

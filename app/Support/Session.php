<?php

namespace MVC\Support;

/**
 * Class Session
 * @package MVC\Support
 */
class Session
{
    /**
     *Init Session
     */
    public static function init()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

  /**
   * @param $key
   * @param $val
   */
    public static function add($key, $val)
    {
        self::init();//Start Session

        $_SESSION[$key] = $val;
    }

    /**
     * Remove an item from Session
     *
     * @param String $key
     *
     * @return void
     */
    //Hủy biến Session
    public static function forget($key)
    {
        self::init();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);//Hủy Session
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    //Kiểm tra xem Session có tồn tại hay không
    public static function has($key)
    {
        self::init();
        return isset($_SESSION[$key]);
    }
    /**
     * @param $key
     * @return string
     */
    public static function get($key)
    {
        self::init();
        return self::has($key) ? $_SESSION[$key] : "";
    }

    /**
     * Destroy all sessions
     *
     * @return void
     */
    public static function destroy()
    {
        session_destroy();
    }
}

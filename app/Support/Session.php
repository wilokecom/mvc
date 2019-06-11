<?php

namespace MVC\Support;

class Session
{
    // Session initialize
    public static function init()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public static function add($key, $val)
    {
        self::init();

        $_SESSION[$key] = $val;
    }

    /**
     * Remove an item from Session
     *
     * @param String $key
     *
     * @return void
     */
    public static function forget($key)
    {
        self::init();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public static function has($key)
    {
        self::init();
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public static function get($key)
    {
        self::init();
        return self::has($key) ? $_SESSION[$key] : '';
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

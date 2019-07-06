<?php declare(strict_types=1);

namespace MVC\Support;

/**
 * Class Session
 * @package MVC\Support
 */
class Session
{
    /**
     * Start Session
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
     * @param String $key
     * @return void
     */
    public static function forget($key)
    {
        self::init();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);//Hủy Session
        }
    }
    /**
     * Check if Sesson exist or not
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        self::init();
        return isset($_SESSION[$key]);
    }
    /**
     * Init Session
     * If session is existed, return Session
     * @param string $key
     * @return string
     */
    public static function get($key)
    {
        self::init();
        return self::has($key) ? $_SESSION[$key] : "";
    }
    /**
     * Destroy all sessions
     * @return void
     */
    public static function destroy()
    {
        session_destroy();
    }
}

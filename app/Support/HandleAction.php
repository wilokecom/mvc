<?php
/**
 * Handle enqueue scripts
 * @category Scripts
 * @package  Wilblog
 * @author   Wiloke <contact.wiloke@email.com>
 */
/**
 *
 */
namespace MVC\Support;

/**
 * Class HandleAction
 * @package MVC\Support
 */
class HandleAction
{
    /**
     * Store script files
     * @var array
     */
    protected static $aHooks;//array(mvcHead:lưu file CSS, mvcFooter:Lưu file JS)
    /**
     * Register hooks
     * @param string $hook
     * @param array|string $aInfo
     * addAction method
     */
    public static function addAction($hook, $aInfo)
    {
        if (!isset(self::$aHooks[$hook])) {//=true
            self::$aHooks[$hook] = array();
        }
        self::$aHooks[$hook][] = $aInfo;
    }
    /**
     * Print scripts
     * @param string $hook
     * @param array  $aParams
     * doAction Method
     */
    public static function doAction($hook, $aParams = array())
    {
        if (isset(self::$aHooks[$hook]) && !empty(self::$aHooks)) {//=true
            foreach (self::$aHooks[$hook] as $hook => $callbackFunc) {
                //Không hiểu sao lại truyền vào 1 mảng
                //$callbackFunc:mảnng(oblect, "phương thức của object")
                call_user_func(
                    $callbackFunc,
                    $aParams
                );
            }
        }
    }
}

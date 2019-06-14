<?php
/**
 * Handle enqueue scripts
 *
 * @category Scripts
 * @package  Wilblog
 * @author   Wiloke <contact.wiloke@email.com>
 */

namespace MVC\Support;


class HandleAction
{

    /**
     * Store script files
     *
     * @var array
     */
    protected static $aHooks;//array(mvcHead:lưu file CSS, mvcFooter:Lưu file JS)

    /**
     * Register hooks
     *
     * @param string $hook
     * @param array|string $aInfo
     *
     * @return $this
     */
    //Phương thức add Action
    public static function addAction($hook, $aInfo)
    {
        if (!isset(self::$aHooks[$hook])) {//=true
            self::$aHooks[$hook] = array();
        }
        /*aHoooks=arr(
        mvcHead arr(
                            0=>arr  (
                                        0=>{MVC\Controller\GeneralScriptController}
                                        1=>'semanticUiCSS'
                                    )
                            )
                     )
        mvcFooter arr(
                            0=>arr  (
                                        0=>{MVC\Controller\GeneralScriptController}
                                        1=>'semanticUiJS'
                                    )
                            )
                     )
    */
        self::$aHooks[$hook][] = $aInfo;
    }

    /**
     * Print scripts
     *
     * @param string $hook
     * @param array $aParams
     *
     * @return void
     */
    //Phương thức doAction
    public static function doAction($hook, $aParams = array())
    {
        if (isset(self::$aHooks[$hook]) && !empty(self::$aHooks)) {//=true
            foreach (self::$aHooks[$hook] as $hook => $callbackFunc) {
                //Không hiểu sao lại truyền vào 1 mảng
                //$callbackFunc:mảnng(oblect, "phương thức của object")
                call_user_func($callbackFunc, $aParams);
            }
        }
    }
}
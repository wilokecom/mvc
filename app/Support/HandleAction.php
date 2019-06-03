<?php
/**
 * Handle enqueue scripts
 * 
 * @category Scripts
 * @package  Wilblog
 * @author   Wiloke <contact.wiloke@email.com>
 */

 namespace MVC\Support;


 class HandleAction{

    /**
     * Store script files
     *
     * @var array
     */
    protected static $aHooks;
    
    /**
     * Register hooks
     *
     * @param string $hook
     * @param array|string $aInfo
     * 
     * @return $this
     */
    public static function addAction($hook, $aInfo){
        if ( !isset(self::$aHooks[$hook]) ){
            self::$aHooks[$hook] = array();
        }
        self::$aHooks[$hook][] = $aInfo;
    }

    /**
     * Print scripts
     * 
     * @param string $hook
     * @param array  $aParams
     * 
     * @return void
     */
    public static function doAction($hook, $aParams=array()){
        if ( isset(self::$aHooks[$hook]) && !empty(self::$aHooks) ){
            foreach( self::$aHooks[$hook] as $hook => $callbackFunc ){
                call_user_func($callbackFunc, $aParams);
            }
        }
    }
 }
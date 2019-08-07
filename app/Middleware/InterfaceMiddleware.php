<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 31/07/2019
 * Time: 11:24 SA
 */
namespace MVC\Middleware;

/**
 * Interface InterfaceMiddleware
 * @package MVC\Middleware
 */
interface InterfaceMiddleware
{
    /**
     * InterfaceMiddleware constructor.
     * @param array $aData
     */
    public function __construct($aData = []);
    public function handle();
}
<?php
namespace MVC\Controllers;

use Jenssegers\Blade\Blade;

/**
 * Class Controller
 * @package MVC\Controllers
 */
class Controller
{
    /**
     * @var
     */
    protected $oViewInstance;
    /**
     * @var
     */
    protected $oControllerInstance;
    /**
     * @var
     */
    protected $modelName;
    /**
     * @var
     */
    protected $oBlade;
    /**
     * Tạm thời không dùng
     * @return \Jenssegers\Blade\Blade
     */
    protected function initPlace() //Tạm thời không dùng
    {
        if (empty($this->oBlade)) {
            $this->oBlade = new Blade(
                MVC_VIEWS,
                MVC_CACHE
            );
        }
        return $this->oBlade;
    }
    /**
     * @param       $viewFile
     * @param array $aData
     * @throws \Exception
     * //Nhảy đến thư mục views
     */
    public function loadView($viewFile, ... $aData)
    {
        try {
            //            extract($aData);
            //$this->initPlace();
            require_once MVC_VIEWS . $viewFile . ".php";
            //$this->oBlade->make($viewFile, $aData);
        } catch (\Exception $oException) {
            throw $oException;
        }
    }
    /**
     * @param       $aMiddleware
     * @param array $aData
     * @throws \Exception
     */
    public function middleware($aMiddleware, $aData = [])
    {
        foreach ($aMiddleware as $middleware) {
            $sMiddlewareClass = getConfig('middleware')->getParam
            (
                $middleware,
                false
            );
            if (!empty($sMiddlewareClass) && class_exists($sMiddlewareClass)) {
                new $sMiddlewareClass($aData);
            } else {
                if (MVC_DEBUG) {
                    throw new\Exception(
                        'This class' . $middleware . 'does not exist'
                    );
                }
            }
        }
    }
}

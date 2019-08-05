<?php declare(strict_types=1);
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
    protected function initPlace()
    {
        if (empty($this->oBlade)) {
            $this->oBlade = new Blade(MVC_VIEWS, MVC_CACHE);
        }
        return $this->oBlade;
    }

    /**
     * @return mixed
     * @param array $aData The data that maybe used in the middleware
     * @param       $aMiddleware $aMiddleware What middleware will be used in this methods
     * @throws \Exception
     */
    protected function middleware($aMiddleware, $aData = [])
    {
        foreach ($aMiddleware as $middleware) {
            //Return MVC\Middleware\AuthMiddleware
            $sMiddlewareClass = getConfig('middleware')->getParam($middleware, false);
            if (!empty($sMiddlewareClass) && class_exists($sMiddlewareClass)) {
                $result =new $sMiddlewareClass($aData);
                return $result->handle();
            } else {
                if (MVC_DEBUG) {
                    throw new \Exception('This class ' . $middleware . ' does not exist');
                }
            }
        }
    }
    /**
     * Go to views folder
     * @param       $viewFile
     * @param array $aData
     *
     * @throws \Exception
     */
    public function loadView($viewFile, ...$aData)
    {
        try {
            //extract($aData);
            require_once MVC_VIEWS . $viewFile . ".php";
            //$this->oBlade->make($viewFile, $aData);
        } catch (\Exception $oException) {
            throw $oException;
        }
    }
}

<?php

namespace MVC\Controllers;

use Jenssegers\Blade\Blade;

/**
 * Class Controller
 *
 * @package MVC\Controllers
 */
class Controller
{
    protected $oViewInstance;
    protected $oControllerInstance;
    protected $modelName;
    protected $oBlade;
    /**
     * @return \Jenssegers\Blade\Blade
     * //Tạm thời không dùng
     */

    protected function initPlace()
    {
        if (empty($this->oBlade)) {
            $this->oBlade = new Blade(MVC_VIEWS, MVC_CACHE);
        }
        return $this->oBlade;
    }
    //Done

    /**
     * @param       $viewFile
     * @param array $aData
     *
     * @throws \Exception
     */
    public function loadView($viewFile, $aData = [])
    {
        /**
         * hàm bẫy lỗi
         */
        try {
            extract($aData);
            //$this->initPlace();
            require_once MVC_VIEWS . $viewFile . '.php';//Nhảy đến views/home/index
            //$this->oBlade->make($viewFile, $aData);
        } catch (\Exception $oException) {
            throw $oException;
        }
    }
}

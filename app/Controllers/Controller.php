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
     * Tạm thời không dùng
     *
     * @return Blade
     */
    protected function initPlace()//Tạm thời không dùng
    {
        if (empty($this->oBlade)) {
            $this->oBlade = new Blade(MVC_VIEWS, MVC_CACHE);
        }
        return $this->oBlade;
    }
    /**
     * @param $viewFile
     * @param array $aData
     * @throws \Exception
     */
    public function loadView($viewFile, $aData = [])//Done, nhảy đến thư mục views
    {
        try {
            //Không hiểu câu lệnh này
            extract($aData);
            //$this->initPlace();
            require_once MVC_VIEWS . $viewFile . ".php";//Nhảy đến views/home/index
            //$this->oBlade->make($viewFile, $aData);
        } catch (\Exception $oException) {
            throw $oException;
        }
    }
}

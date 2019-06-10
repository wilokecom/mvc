<?php

namespace MVC\Controllers;

use Jenssegers\Blade\Blade;

class Controller
{
    protected $oViewInstance;
    protected $oControllerInstance;
    protected $modelName;
    protected $oBlade;

    //Tạm thời không dùng
    protected function initPlace()
    {
        if (empty($this->oBlade)) {
            $this->oBlade = new Blade(MVC_VIEWS, MVC_CACHE);
        }
        return $this->oBlade;
    }

    //Done
    public function loadView($viewFile, $aData = [])
    {
        try {
            //Không hiểu câu lệnh này
            extract($aData);
            //$this->initPlace();
            require_once MVC_VIEWS . $viewFile . '.php';//Nhảy đến views/home/index
            //$this->oBlade->make($viewFile, $aData);
        } catch (\Exception $oException) {
            throw $oException;
        }
    }
}

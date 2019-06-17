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
            $this->oBlade = new Blade(MVC_VIEWS, MVC_CACHE);
        }
        return $this->oBlade;
    }
    /**
     * @param       $viewFile
     * @param array $aData
     * @throws \Exception
     */
    public function loadView($viewFile, $aData = [])//Nhảy đến thư mục views
    {
        try {
            //Không hiểu câu lệnh này
            extract($aData);
            //$this->initPlace();
            require_once MVC_VIEWS .$viewFile.".php";//Nhảy đến views/home/index
            //$this->oBlade->make($viewFile, $aData);
        } catch (\Exception $oException) {
            throw $oException;
        }
    }
}

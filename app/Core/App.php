<?php

namespace MVC\Core;

/**
 * Đường dẫn URL:admin-home/login-admin-home/1
 * Class App
 *
 * @package MVC\Core
 */
class App
{
    /**
     * Controller
     * @var string
     */
    protected $controllerName = "HomeController";
    /**
     * Action
     * @var string
     */
    protected $methodName = "index";
    /**
     * Object of Class Controller
     * @var
     */
    protected $oControllerInstance;
    /**
     * Param
     * @var array
     */
    protected $aParams = [];
    /**
     * explode:Phá chuỗi thành mảng
     * filter_var:Kiểm tra đường dẫn url
     * rtrim:Xóa khoảng trắng và kí tự / ở cuối
     * @return array
     */
    public function parseUrl()
    {
        if (isset($_GET["route"])) {
            return explode("/", filter_var(rtrim($_GET["route"], "/"), FILTER_SANITIZE_URL));
        }
    }
    /**
     * array_map:Trả về mảng.Truyền tham số $name vào function($item)
     * @return string
     * @param $name
     */
    protected function parseName($name)
    {
        $name = explode("-", $name);
        $aParseName = array_map(function ($item) {
            return ucfirst($item);
        }, $name);
        return implode($aParseName, "");
    }

    /**
     * @return string
     */
    protected function generateControllerName()//AdminHomeController
    {
        if (empty($this->aParams)) {
            return "";
        }
        $controllerName = $this->parseName($this->aParams[0])."Controller";
        unset($this->aParams[0]);//Xóa phần tử mảng
        return $controllerName;
    }
    /**
     * @return string
     *
     * @param $controllerName
     */
    protected function generateControllerFile($controllerName)//AdminHomeController
    {
        return $controllerName.".php";
    }
    /**
     * @return bool
     *
     * @param $controllerName
     */
    protected function isControllerExists($controllerName)//Kiểm tra đường dẫn đến file Controller.php có tồn tại
    {
        return file_exists(MVC_CONTROLLERS
            . $this->generateControllerFile($controllerName));
    }
    /**
     * @param $controllerName
     */
    protected function initController($controllerName)//Khởi tạo Class Controller
    {
        if ($this->isControllerExists($controllerName)) {
            $this->controllerName = $controllerName;
        }
        require_once MVC_CONTROLLERS . $this->generateControllerFile($this->controllerName); //VD:\MVC\Controllers\HomeController
        $this->controllerName = "\MVC\Controllers\\" . $this->controllerName; //VD:{MVC\Controllers\HomeController}
        $this->oControllerInstance = new $this->controllerName;
    }

    /**
     * Kiểm tra method có tồn tại hay không
     * method_exists(object, mothodName)
     * @return bool
     *
     * @param $methodName
     */
    protected function isMethodExist($methodName)
    {
        return method_exists($this->oControllerInstance, $methodName);
    }

    /**
     * @return string
     */
    protected function generateMethodName()//Trả về mothod name:loginAdminHome
    {
        if (empty($this->aParams) || !isset($this->aParams[1])) {
            return "";
        }
        if (isset($this->aParams[1])) {
            $methodName = $this->parseName($this->aParams[1]);
            unset($this->aParams[1]);//Xóa method
            return lcfirst($methodName);
        }
    }
    /**
     * call_user_func_array:Gọi đến phương thức $this->methodName
     * $this->oControllerInstance:là 1 đối tượng của class
     * array($this->aParams):Tham số truyền vào phương thức
     * @param $methodName
     */
    protected function callMethod($methodName)
    {
        if (!empty($methodName) && $this->isMethodExist($methodName)) {
            $this->methodName = $methodName;
        }
        //Sau lệnh này sẽ nhảy đến method của Controller
        call_user_func_array(array(
            $this->oControllerInstance,
            $this->methodName
        ), array($this->aParams));
    }
    /**
     * App constructor.
     */
    public function __construct()//Hàm khởi tạo
    {
        $this->aParams = $this->parseUrl();
        // Init Controller
        $controllerName = $this->generateControllerName();//AdminHomeController
        $this->initController($controllerName);
        // Init Method
        $methodName = $this->generateMethodName();//LoginAdminHome
        $this->callMethod($methodName);
    }
}
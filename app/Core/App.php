<?php

namespace MVC\Core;
class App
{
    //Đường dẫn URL:admin-home/login-admin-home/1
    protected $controllerName = "HomeController";//Controller
    protected $methodName = "index";//Action
    protected $oControllerInstance;//Đối tượng của Class Controller
    protected $aParams = [];//Param
    //explode:Phá chuỗi thành mảng
    //filter_var:Kiểm tra đường dẫn url
    //rtrim:Xóa khoảng trắng và kí tự / ở cuối
    public function parseUrl()
    {
        if (isset($_GET["route"])) {
            return explode("/", filter_var(rtrim($_GET["route"], "/"), FILTER_SANITIZE_URL));
        }
    }
    //array_map:Trả về mảng.Truyền tham số $name vào function($item)
    protected function parseName($name)
    {
        $name = explode("-", $name);

        $aParseName = array_map(function ($item) {
            return ucfirst($item);
        }, $name);

        return implode($aParseName, "");
    }
    //AdminHomeController
    protected function generateControllerName()
    {
        if (empty($this->aParams)) {
            return "";
        }
        $controllerName = $this->parseName($this->aParams[0]) . "Controller";
        unset($this->aParams[0]);//Xóa phần tử mảng
        return $controllerName;
    }
    //Trả về file Controller.php
    protected function generateControllerFile($controllerName)
    {
        return $controllerName . ".php";
    }
    //Kiểm tra đường dẫn đến file Controller.php có tồn tại
    protected function isControllerExists($controllerName)
    {
        return file_exists(MVC_CONTROLLERS . $this->generateControllerFile($controllerName));
    }
    //Khởi tạo Class Controller
    protected function initController($controllerName)
    {
        if ($this->isControllerExists($controllerName)) {
            $this->controllerName = $controllerName;
        }
        require_once MVC_CONTROLLERS . $this->generateControllerFile($this->controllerName);
        //VD:\MVC\Controllers\HomeController
        $this->controllerName = "\MVC\Controllers\\" . $this->controllerName;
        //VD:{MVC\Controllers\HomeController}
        $this->oControllerInstance = new $this->controllerName;
    }
    //Kiểm tra method có tồn tại hay không
    //method_exists(object, mothodName)
    protected function isMethodExist($methodName)
    {
        return method_exists($this->oControllerInstance, $methodName);
    }
    //Trả về mothod name:loginAdminHome
    protected function generateMethodName()
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
    //call_user_func_array:Gọi đến phương thức $this->methodName
    //$this->oControllerInstance:là 1 đối tượng của class
    //array($this->aParams):Tham số truyền vào phương thức
    protected function callMethod($methodName)
    {
        if (!empty($methodName) && $this->isMethodExist($methodName)) {
            $this->methodName = $methodName;
        }
        //Sau lệnh này sẽ nhảy đến method của Controller
        call_user_func_array(array($this->oControllerInstance, $this->methodName), array($this->aParams));//loginAdminHome
    }
    //Hàm khởi tạo
    public function __construct()
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
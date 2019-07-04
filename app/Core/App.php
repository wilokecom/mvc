<?php declare(strict_types=1);

namespace MVC\Core;

/**
 * Link URL(Example):admin-home/login-admin-home/1
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
    protected $controllerName = "HomeController";//Controller
    /**
     * Action
     * @var string
     */
    protected $methodName = "index";//Action
    /**
     * The object of Class Controller
     * @var
     */
    protected $oControllerInstance;
    /**
     * Param
     * @var array
     */
    protected $aParams = [];//Param
    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->aParams = $this->parseUrl();
        // Init Controller
        $controllerName = $this->generateControllerName();
        $this->initController($controllerName);
        // Init Method
        $methodName = $this->generateMethodName();
        //Init Param
        $this->callMethod($methodName);
    }
    /**
     * explode:expode string to array
     * filter_var:Check url path
     * rtrim:Delete space and character "/" at the end of string
     * @return array
     */
    public function parseUrl()
    {
        if (isset($_GET["route"])) {
            return explode("/", filter_var(rtrim($_GET["route"], "/"), FILTER_SANITIZE_URL));
        }
    }
    /**
     * array_map:Return array.Transmit parameter $name to function($item)
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
     * Return controller from url link
     * @return string
     */
    protected function generateControllerName()
    {
        if (empty($this->aParams)) {
            return "";
        }
        $controllerName = $this->parseName($this->aParams[0])."Controller";
        unset($this->aParams[0]);//Delete array element
        return $controllerName;
    }
    /**
     * Return controllerName.php
     * @return string
     * @param $controllerName
     */
    protected function generateControllerFile($controllerName)
    {
        return $controllerName.".php";
    }
    /**
     * Check file controller.php is exist or not
     * @return bool
     * @param $controllerName
     */
    protected function isControllerExists($controllerName)
    {
        return file_exists(
            MVC_CONTROLLERS . $this->generateControllerFile($controllerName)
        );
    }
    /**
     * Init Class Controller
     * @param $controllerName
     */
    protected function initController($controllerName)//Khởi tạo Class Controller
    {
        if ($this->isControllerExists($controllerName)) {
            $this->controllerName = $controllerName;
        }
        //Ex:\MVC\Controllers\HomeController
        require_once MVC_CONTROLLERS . $this->generateControllerFile($this->controllerName);
        $this->controllerName = "\MVC\Controllers\\" . $this->controllerName; //Ex:{MVC\Controllers\HomeController}
        $this->oControllerInstance = new $this->controllerName;
    }

    /**
     * Check method is exist or not
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
     * Return Method name
     * @return string
     */
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
    /**
     * call_user_func_array:Call method $this->methodName
     * $this->oControllerInstance:is an object of class
     * array($this->aParams):parameter which is transmited method
     * @param $methodName
     */
    protected function callMethod($methodName)
    {
        if (!empty($methodName) && $this->isMethodExist($methodName)) {
            $this->methodName = $methodName;
        }
        //Go to method of Controller
        call_user_func_array(array(
            $this->oControllerInstance,
            $this->methodName
        ), array($this->aParams));
    }
}

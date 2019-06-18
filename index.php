<?php
use MVC\Controllers\GeneralScriptsController;
use MVC\Core\App;
use MVC\Support\HandleAction;
//Cài đặt cảnh báo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Done
/**
 * @param $fileName
 *
 * @return \MVC\Support\Config
 */
function getConfig($fileName)
{
    return new \MVC\Support\Config($fileName);
}

//Done
/**
 * @param $hook
 */
function doAction($hook)
{
    //Nhảy đến phương thức loadClass trong file ClassLoder.php
    //HandleAction:Class
    //addAction:Phương thức tĩnh
    HandleAction::doAction($hook);
}

//Done
/**
 * @param $hook
 * @param $aInfo
 */
function addAction($hook, $aInfo)
{
    //Nhảy đến phương thức loadClass trong file ClassLoder.php
    //HandleAction:Class
    //addAction:Phương thức tĩnh
    HandleAction::addAction($hook, $aInfo);//require file HandleAction.php và nhảy đến hàm addAction($hook, $aInfo)
}

/**
 * @param $file
 *             //include file view
 */
function incViewFile($file)
{
    include MVC_VIEWS . $file . '.php';
}

/**
 * @param $url
 *            //Done.Trả về đường dẫn url file JS
 */
function mvcEnqueueScript($url)
{
    ?>
    <script src="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>"></script>
    <?php
}

/**
 * @param $url
 *            //Done.Trả về đường dẫn url file css
 */
function mvcEnqueueStyle($url)
{
    ?>
    <link rel="stylesheet" href="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>">
    <?php
}

require_once './vendor/autoload.php';//Nhảy đến file vendor/autoload.php
require_once './configs/general.php';
//Chưa hiểu
new GeneralScriptsController;//require file GeneralScriptsController.php và nhảy đến hàm construct
new App;//require file App.php và nhảy đến hàm construct

<?php
use MVC\Controllers\GeneralScriptsController;
use MVC\Core\App;
use MVC\Support\HandleAction;

//Cài đặt cảnh báo
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
//Done
function getConfig($fileName)
{
    //Include file \Support\Config($fileName)
    return new \MVC\Support\Config($fileName);
}
//Done
function doAction($hook)
{
    //Nhảy đến phương thức loadClass trong file ClassLoder.php
    //Nhanyr đến file app/Support/HandleAction.php .Phương thức doAction
    HandleAction::doAction($hook);
}
//Done
function addAction($hook, $aInfo)
{
    //Nhảy đến phương thức loadClass trong file ClassLoder.php
    //HandleAction:Class
    //addAction:Phương thức tĩnh
    //require file app/Support/HandleAction.php và nhảy đến hàm addAction($hook, $aInfo)
    HandleAction::addAction($hook, $aInfo);
}

//include file views/  .Include header và footer
function incViewFile($file)
{
    include MVC_VIEWS . $file . ".php";
}

////Done.Trả về đường dẫn url file JS
function mvcEnqueueScript($url)
{
    ?>
    <script src="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>"></script>
    <?php
}
//Done.Trả về đường dẫn url file css
function mvcEnqueueStyle($url)
{
    ?>
    <link rel="stylesheet" href="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>">
    <?php
}
//$composer_autoload_files=array();
require_once "./vendor/autoload.php";//Nhảy đến file vendor/autoload.php
require_once "./configs/general.php";
//Load file CSS và file JS
new GeneralScriptsController;//require file GeneralScriptsController.php và nhảy đến hàm construct
new App;//require file App.php và nhảy đến hàm construct

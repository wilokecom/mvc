<?php
use MVC\Support\HandleAction;
use MVC\Core\App;
use MVC\Controllers\GeneralScriptsController;

require_once './configs/general.php';

//Cài đặt cảnh báo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Done
function getConfig($fileName){
	return new \MVC\Support\Config($fileName);
}
//Done
function doAction($hook){
    //Nhảy đến phương thức loadClass trong file ClassLoder.php
    //HandleAction:Class
    //addAction:Phương thức tĩnh
	HandleAction::doAction($hook);
}
//Done
function addAction($hook, $aInfo){
    //Nhảy đến phương thức loadClass trong file ClassLoder.php
    //HandleAction:Class
    //addAction:Phương thức tĩnh
	HandleAction::addAction($hook, $aInfo);
}
//include file view
function incViewFile($file){
	include MVC_VIEWS . $file .'.php';
}
////Done.Trả về đường dẫn url file JS
function mvcEnqueueScript($url){
	?>
	<script src="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>"></script>
	<?php
}
//Done.Trả về đường dẫn url file css
function mvcEnqueueStyle($url){
	?>
	<link rel="stylesheet" href="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>">
	<?php
}
//$composer_autoload_files=array();
require_once  './vendor/autoload.php';

new GeneralScriptsController;
new App;
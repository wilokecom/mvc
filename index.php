<?php
use MVC\Support\HandleAction;
use MVC\Core\App;
use MVC\Controllers\GeneralScriptsController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getConfig($fileName){
	return new \MVC\Support\Config($fileName);
}

function doAction($hook){
	HandleAction::doAction($hook);
}

function addAction($hook, $aInfo){
	HandleAction::addAction($hook, $aInfo);
}

function incViewFile($file){
	include MVC_VIEWS . $file .'.php';
}

function mvcEnqueueScript($url){
	?>
	<script src="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>"></script>
	<?php
}

function mvcEnqueueStyle($url){
	?>
	<link rel="stylesheet" href="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>">
	<?php
}

require_once  './vendor/autoload.php';

require_once  './configs/general.php';  

new GeneralScriptsController;
new App;
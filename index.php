<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getConfig($fileName){
	return new \MVC\Support\Config($fileName);
}

require_once  './vendor/autoload.php';

require_once  './configs/general.php';
require_once  MVC_CORE . 'App.php';
require_once MVC_CONTROLLERS . 'Controller.php';

new \MVC\Core\App();
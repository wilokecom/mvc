<?php declare(strict_types=1);
use MVC\Controllers\GeneralScriptsController;
use MVC\Core\App;
use MVC\Support\HandleAction;
use MVC\Support\Config;

/**
 * Setup warning
 */
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
/**
 * Include file \Support\Config($fileName)
 * @return \MVC\Support\Config
 * @param $fileName
 */
function getConfig($fileName)//Done
{
    return new Config($fileName);
}
/**
 * Go to method loadClass in file ClassLoder.php
 * Go to the app / Support / HandleAction.php file. DoAction method
 * @param $hook
 */
function doAction($hook)//Done
{
    HandleAction::doAction($hook);
}
/**
 * Jump to loadClass method in ClassLoder.php file
 * HandleAction:Class
 * require file app/Support/HandleAction.php and go to addAction($hook, $aInfo)
 * @param $hook
 * @param $aInfo
 */
function addAction($hook, $aInfo)//Done
{
    HandleAction::addAction($hook, $aInfo);
}
/**
 * include file views/  .Include header and footer
 * @param $file
 */
function incViewFile($file)
{
    include MVC_VIEWS . $file . ".php";
}
/**
 * Return url file JS
 * @param $url
 */
function mvcEnqueueScript($url)
{
    ?>
    <script src="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>"></script>
    <?php
}
/**
 * Return url file CSS
 * @param $url
 */
function mvcEnqueueStyle($url)
{
    ?>
    <link rel="stylesheet"
          href="<?php echo filter_var($url, FILTER_SANITIZE_URL); ?>">
    <?php
}
/**
 * $composer_autoload_files=array();
 */
require_once "./vendor/autoload.php";
require_once "./configs/general.php";
/**
 * Load file CSS and file JS
 */
new GeneralScriptsController;//require file GeneralScriptsController.php and go to function construct
new App;//require file App.php and go to function construct
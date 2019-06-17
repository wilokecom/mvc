<?php
/**
 * This place will generate scripts on all pages
 *
 * @category Script
 * @package  MVC
 * @author   Wiloke <email@email.com>
 * @license  Wiloke
 * @link     http://wiloke.com
 * @since    1.0.0
 */
namespace MVC\Controllers;

/**
 * Init GeneralScriptsController
 */
class GeneralScriptsController
{
    //Hàm khởi tạo
    public function __construct()
    {
        //Nhảy sang hàm addAction
        addAction("mvcHead", array($this, "semanticUiCSS"));
        addAction("mvcFooter", array($this, "sematicUiJS"));
    }
    //Done.Lấy đường dẫn css
    public function semanticUiCSS()
    {
        //Chạy đến hàm mvcEnqueueStyle-file index.php
        mvcEnqueueStyle(MVC_SOURCES_URL . "css/style.css");
        mvcEnqueueStyle(MVC_ASSETS_URL . "semantic/semantic.min.css");
    }
    //Done:Lấy đường dẫn JS
    public function sematicUiJS()
    {   //Chạy đến hàm mvcEnqueueScript-file index.php
        mvcEnqueueScript("https://code.jquery.com/jquery-3.4.1.min.js");
        mvcEnqueueScript(MVC_ASSETS_URL . "semantic/semantic.min.js");
    }
}
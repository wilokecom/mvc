<?php
namespace MVC\Controllers;

/**
 * Class GeneralScriptsController
 *
 * @package MVC\Controllers
 */
class GeneralScriptsController
{
    /**
     * GeneralScriptsController constructor.
     */
    public function __construct()//Hàm khởi tạo
    {
        //Nhảy sang hàm addAction
        addAction("mvcHead", array($this, "semanticUiCSS"));
        addAction("mvcFooter", array($this, "sematicUiJS"));
    }

    /**
     * Lấy đường dẫn css
     */
    public function semanticUiCSS() //Done.Lấy đường dẫn css
    {
        //Chạy đến hàm mvcEnqueueStyle-file index.php
        mvcEnqueueStyle(MVC_SOURCES_URL . "css/style.css");
        mvcEnqueueStyle(MVC_ASSETS_URL . "semantic/semantic.min.css");
    }

    /**
     * Lấy đường dẫn JS
     */
    public function sematicUiJS()  //Done:Lấy đường dẫn JS
    {
        //Chạy đến hàm mvcEnqueueScript-file index.php
        mvcEnqueueScript("https://code.jquery.com/jquery-3.4.1.min.js");
        mvcEnqueueScript(MVC_ASSETS_URL . "semantic/semantic.min.js");
    }
}

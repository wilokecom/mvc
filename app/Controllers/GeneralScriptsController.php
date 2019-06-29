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
     * Hàm khởi tạo
     * GeneralScriptsController constructor.
     * Nhảy sang hàm addAction
     */
    public function __construct()
    {
        addAction("mvcHead", array($this, "semanticUiCSS"));
        addAction("mvcFooter", array($this, "sematicUiJS"));
    }

    /**
     * Lấy đường dẫn css
     * Chạy đến hàm mvcEnqueueStyle-file index.php
     */
    public function semanticUiCSS() //Done.Lấy đường dẫn css
    {
        mvcEnqueueStyle(MVC_SOURCES_URL ."css/style.css");
        mvcEnqueueStyle(MVC_ASSETS_URL . "semantic/semantic.min.css");
        mvcEnqueueStyle(MVC_ASSETS_URL . "jqueryUI/jquery-ui.css");
    }

    /**
     * Lấy đường dẫn JS
     * Chạy đến hàm mvcEnqueueScript-file index.php
     */
    public function sematicUiJS()  //Done:Lấy đường dẫn JS
    {
        mvcEnqueueScript(MVC_ASSETS_URL."jquery/jquery-3.4.1.min.js");
        mvcEnqueueScript(MVC_ASSETS_URL."jqueryUI/jquery-ui.js");
        mvcEnqueueScript(MVC_ASSETS_URL . "semantic/semantic.min.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/showContent_jquery.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/showPassword_jquery.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/focusInput_jquery.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/alertDeleteDialog_jquery.js");
    }
}

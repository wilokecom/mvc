<?php declare(strict_types=1);
namespace MVC\Controllers;

/**
 * Class GeneralScriptsController
 * @package MVC\Controllers
 */
class GeneralScriptsController
{
    /**
     * GeneralScriptsController constructor.
     * Nhảy sang hàm addAction
     */
    public function __construct()
    {
        addAction("mvcHead", array($this, "semanticUiCSS"));
        addAction("mvcFooter", array($this, "sematicUiJS"));
    }
    /**
     * Get url CSS
     * Go to function mvcEnqueueStyle-file index.php
     */
    public function semanticUiCSS()
    {
        mvcEnqueueStyle(MVC_SOURCES_URL ."css/style.css");
        mvcEnqueueStyle(MVC_ASSETS_URL . "semantic/semantic.min.css");
        mvcEnqueueStyle(MVC_ASSETS_URL . "semantic/components/sidebar.css");
        mvcEnqueueStyle(MVC_ASSETS_URL . "jqueryUI/jquery-ui.css");
    }
    /**
     * Get url JS
     * Go to function mvcEnqueueScript-file index.php
     */
    public function sematicUiJS()
    {
        mvcEnqueueScript(MVC_ASSETS_URL . "jquery/jquery-3.4.1.min.js");
        mvcEnqueueScript(MVC_ASSETS_URL . "jqueryUI/jquery-ui.js");
        mvcEnqueueScript(MVC_ASSETS_URL . "semantic/semantic.min.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/showContent.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/showPassword.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/focusInput.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/showPagination.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/alertDeleteDialog.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/toggleSidebar.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/addNewTaxonomy.js");
        mvcEnqueueScript(MVC_SOURCES_URL . "js/showPost.js");
    }
}

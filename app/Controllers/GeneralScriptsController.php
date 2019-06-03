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
 class GeneralScriptsController{
    public function __construct()
    {
        addAction('mvcHead', array($this, 'semanticUiCSS'));
        addAction('mvcFooter', array($this, 'sematicUiJS'));
    }

    public function semanticUiCSS(){
        mvcEnqueueStyle(MVC_SOURCES_URL.'css/style.css');
        mvcEnqueueStyle(MVC_ASSETS_URL.'semantic/semantic.min.css');
    }

    public function sematicUiJS(){
        mvcEnqueueScript('https://code.jquery.com/jquery-3.4.1.min.js');
        mvcEnqueueScript(MVC_ASSETS_URL.'semantic/semantic.min.js');
    }
 }
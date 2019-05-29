<?php
namespace MVC\Core;

class App {
	protected $controllerName = 'HomeController';
	protected $methodName = 'index';
	protected $oControllerInstance;
	protected $aParams = [];

	public function parseUrl(){
		if ( isset($_GET['route']) ){
			return explode('/', filter_var(rtrim($_GET['route'], '/'), FILTER_SANITIZE_URL));
		}
	}

	protected function parseName($name){
		$name = explode('-', $name);

		$aParseName = array_map(function($item){
			return ucfirst($item);
		}, $name);

		return implode($aParseName,'');
	}

	protected function generateControllerName(){
		if ( empty($this->aParams) ){
			return '';
		}

		$controllerName = $this->parseName($this->aParams[0]) . 'Controller';
		unset($this->aParams[0]);
		return $controllerName;
	}

	protected function generateControllerFile($controllerName){
		return $controllerName . '.php';
	}

	protected function isControllerExists($controllerName){
		return file_exists(MVC_CONTROLLERS . $this->generateControllerFile($controllerName));
	}

	protected function initController($controllerName){
		if ( $this->isControllerExists($controllerName) ){
			$this->controllerName = $controllerName;
		}

		require_once MVC_CONTROLLERS . $this->generateControllerFile($this->controllerName);
		$this->controllerName = '\MVC\Controllers\\' . $this->controllerName;

		$this->oControllerInstance = new $this->controllerName;
	}

	protected function isMethodExist($methodName){
		return method_exists($this->oControllerInstance, $methodName);
	}

	protected function generateMethodName(){
		if ( empty($this->aParams) || !isset($this->aParams[1]) ){
			return '';
		}

		if ( isset($this->aParams[1]) ){
			$methodName = $this->parseName($this->aParams[1]);
			unset($this->aParams[1]);
			return $methodName;
		}
	}

	protected function callMethod($methodName){
		if ( !empty($methodName) && $this->isMethodExist($methodName) ){
			$this->methodName = $methodName;
		}
		call_user_func(array($this->oControllerInstance, $this->methodName), $this->aParams);
	}

	public function __construct() {
		$this->aParams = $this->parseUrl();
		// Init Controller
		$controllerName = $this->generateControllerName();
		$this->initController($controllerName);


		// Init Method
		$methodName = $this->generateMethodName();
		$this->callMethod($methodName);

	}
}
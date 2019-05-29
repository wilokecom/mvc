<?php
namespace  MVC\Controllers;

use Jenssegers\Blade\Blade;

class Controller{
	protected $oViewInstance;
	protected $oControllerInstance;
	protected $modelName;
	protected $oBlade;

	protected function generateModelFile(){
		return $this->modelName . '.php';
	}

	protected function generateModelDir() {
		return MVC_MODELS . $this->generateModelFile();
	}

	protected function isModelExists(){
		return file_exists($this->generateModelDir());
	}

	protected function parseModelName($model){
		$this->modelName = str_replace('Controller', 'Model', $model);
	}

	protected function loadModel($model){
		$this->parseModelName($model);

		if ( $this->isModelExists() ){
			require_once $this->generateModelDir();
			return new $this->modelName;
		}

		return false;
	}

	protected function initPlace(){
		if ( empty($this->oBlade) ){
			$this->oBlade = new Blade(MVC_VIEWS, MVC_CACHE);
		}

		return $this->oBlade;
	}

	public function loadView($viewFile, $aData = []){
		try{
			extract($aData);
			$this->initPlace();
			//require_once MVC_VIEWS . $viewFile . '.php';
			$this->oBlade->make($viewFile, $aData);
		}catch (\Exception $oException){
			throw $oException;
		}
	}
}

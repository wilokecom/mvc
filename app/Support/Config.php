<?php
namespace MVC\Support;
/*
 * Get configuration
 */
class Config{
	/*
	 * @param String
	 */
	private static $fileName;
	/*
	 * @param Array
	 */
	private static $aConfiguration;
	/*
	 * @param Array | String
	 */
	private static $aValue;
	/*
	 * Specifying the file that you want to get
	 *
	 * @param $fileName String
	 * @return Array | String
	 */
	 public function __construct($fileName, $hasChain=false) {
		self::$fileName = $fileName;
		if ( isset(self::$aConfiguration[$fileName]) ){
			self::$aConfiguration[$fileName];
		}else{
			if ( file_exists(MVC_CONFIG . $fileName . '.php') ){
				self::$aConfiguration[$fileName] = include MVC_CONFIG . $fileName . '.php';
			}else{
				self::$aConfiguration[$fileName] = array();
			}
		}
		self::$aValue = self::$aConfiguration[$fileName];
	}
	/*
	 * Getting all configuration
	 * @return Closure | Array | String | NULL
	 */
	public function getAll(){
		return self::$aValue;
	}
	/*
	 * Getting configuration
	 *
	 * @param $target String
	 * @param $hasChain Bool
	 *
	 * @return Closure | Array | String | NULL
	 */
	//Done
	public function getParam($target, $hasChain=false){
		self::$aValue = isset(self::$aValue) ? self::$aValue[$target] : null;
		if ( $hasChain ){
			return $this;
		}
		return self::$aValue;
	}
} 
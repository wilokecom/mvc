<?php

namespace MVC\Database;


use MVC\Support\Config;

abstract class DBFactory {
	/*
	 * @param Closure
	 */
	private static $oDB;

	/*
	 * Connect to databse
	 *
	 * @return \MVC\Database\DBInterface
	 */
	protected static function connect(){
		$grammar = getConfig('database')->getParam('default');

		switch ( $grammar ){
			case 'mysql':
				self::$oDB = new MysqlGrammar(getConfig('database')->getParam('connections', true)->getParam($grammar));
				return self::$oDB->connect();
				break;
			case 'sqlite':
				self::$oDB = new MysqlGrammar(getConfig('database')->getParam('connections', true)->getParam($grammar));
				return self::$oDB->connect();
				break;
		}
	}
}
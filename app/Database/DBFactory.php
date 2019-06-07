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
	    //Nhảy đền hàm getConfig-file index.php-->Nhảy đến phương thức getParam -file Support.Config.php
		$grammar = getConfig('database')->getParam('default');

		switch ( $grammar ){
			case 'sqlite':
				self::$oDB = new MysqlGrammar(getConfig('database')->getParam('connections', true)->getParam($grammar));
				return self::$oDB->connect();
				break;
            case 'mysqli':
                self::$oDB = new MysqlGrammar(getConfig('database')->getParam('connections', true)->getParam($grammar));
                return self::$oDB->connect();
                break;

		}
	}
}
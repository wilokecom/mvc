<?php declare(strict_types=1);
namespace MVC\Database;

/**
 * Class DBFactory
 * @package MVC\Database
 */
abstract class DBFactory
{
    /**
     * Object database:Init library mysqli(MysqlGrammar.php)
     * @var
     */
    private static $oDB;
    /**
     * connect database
     * $grammar = getConfig("database")->getParam("default"):
     * Go to function getConfig-file index.php
     * Include file \Support\Config(database)
     * Go to function construct of file \Support\Config(database)
     * Go to method getParam("default")
     * Return library mysqli
     * @return \MVC\Database\DBInterface
     */
    protected static function connect():DBInterface
    {
        $grammar = getConfig("database")->getParam("default");
        switch ($grammar) {
            case "sqlite":
                self::$oDB = new MysqlGrammar(getConfig("database")
                    ->getParam("connections", true)->getParam($grammar));
                return self::$oDB->connect();
                break;
            case "mysqli":
                /**
                 * nclude app/Database/MysqlGrammar.php implement DBInterface.php-->Include DBInterface.php
                 * Go to function construct of file \Support\Config(database)
                 * Go to method getParam(connections", true))
                 * Go to method getParam(mysqli)
                 * Note that the construc function is overwritten
                 */
                self::$oDB = new MysqlGrammar(getConfig("database")
                    ->getParam("connections", true)->getParam($grammar));
                return self::$oDB->connect();
                break;
        }
    }
}

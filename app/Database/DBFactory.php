<?php
namespace MVC\Database;

/**
 * Class DBFactory
 * @package MVC\Database
 */
abstract class DBFactory
{
    /**
     * @var
     */
    private static $oDB;//Object database:Khởi tạo thư viện mysqli(MysqlGrammar.php)

    /**
     * @return \MVC\Database\DBInterface
     */
    protected static function connect():DBInterface //connect database
    {
        //jump into function getConfig-file index.php
        //Include file \Support\Config(database)
        //Nhảy đến hàm construct của file \Support\Config(database)
        //Nhảy đến phương thức getParam("default")
        //returnt mysqli library
        $grammar = getConfig("database")->getParam("default");
        switch ($grammar) {
            case "sqlite":
                self::$oDB = new MysqlGrammar(getConfig("database")
                    ->getParam("connections", true)->getParam($grammar));
                return self::$oDB->connect();
                break;
            case "mysqli":
                //Include app/Database/MysqlGrammar.php implement DBInterface.php-->Include DBInterface.php
                //Nhảy đến hàm construct của file \Support\Config(database)
                //Nhảy đến phương thức getParam(connections", true))
                //Nhảy đến phương thức getParam(mysqli)
                //Chú ý ở đây hàm construc bị ghi đè
                self::$oDB = new MysqlGrammar(getConfig("database")
                    ->getParam("connections", true)->getParam($grammar));
                return self::$oDB->connect();
                break;
        }
    }
}

<?php

namespace MVC\Database;

/**
 * Class DBFactory
 *
 * @package MVC\Database
 */
abstract class DBFactory
{
    /*
     * @param Closure
     */
    private static $oDB;//Object database:Khởi tạo thư viện mysqli(MysqlGrammar.php)
    /**
     * Connect to databse
     *
     * @return \MVC\Database\DBInterface
     */
    //connect database
    protected static function connect(): DBInterface
    {
        //Nhảy đến hàm getConfig-file index.php
        //Include file \Support\Config(database)
        //Nhảy đến hàm construct của file \Support\Config(database)
        //Nhảy đến phương thức getParam('default')
        //Trả về thư viện mysqli
        $grammar = getConfig('database')->getParam('default');
        switch ($grammar) {
            case 'sqlite':
                self::$oDB = new MysqlGrammar(getConfig('database')->getParam('connections', true)->getParam($grammar));

                return self::$oDB->connect();
                break;
            case 'mysqli':
                //Include app/Database/MysqlGrammar.php implement DBInterface.php-->Include DBInterface.php
                //Nhảy đến hàm construct của file \Support\Config(database)
                //Nhảy đến phương thức getParam(connections', true))
                //Nhảy đến phương thức getParam(mysqli)
                //Chú ý ở đây hàm construc bị ghi đè
                self::$oDB = new MysqlGrammar(getConfig('database')->getParam('connections', true)->getParam($grammar));
                return self::$oDB->connect();
                break;
        }
    }
}

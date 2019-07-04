<?php declare(strict_types=1);
namespace MVC\Models;

use MVC\Database\DBFactory;

/**
 * Class UserModel
 * @package MVC\Models
 */
class UserModel extends DBFactory
{
    /**
     * @return bool or array
     * @param $sUsername
     */
    public static function getUserByUsername($sUsername)
    {
        $query   = "SELECT * FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aParam  = array($sUsername);
        $aStatus = self::connect()->prepare($query, $aParam)->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];
    }
    /**
     * @return bool ỏ array
     * @param $sPassword
     * @param $sUsername
     */
    public static function checkUserLogin($sUsername, $sPassword)
    {
        $query   = "SELECT * FROM users WHERE username=? AND password=? ORDER BY ID LIMIT 1";
        $aParam  = array($sUsername, md5($sPassword));
        $aStatus = self::connect()->prepare($query, $aParam)->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];
    }
    /**
     * @return mixed
     * @param $sUsername
     */
    public static function usernameExists($sUsername)
    {
        return self::connect()->prepare("SELECT username FROM users WHERE username=?", array($sUsername))->select();
    }
    /**
     * @return mixed
     * @param $sUsername
     */
    public static function emailExists($sUsername)
    {
        return self::connect()
            ->prepare("SELECT email FROM users WHERE email=?", array($sUsername))->select();
    }
    /**
     * @return mixed
     * @param $sEmail
     * @param $sPassword
     * @param $sUsername
     */
    public static function insertNewUser($sUsername, $sEmail, $sPassword)
    {
        $aParams = array($sUsername, $sEmail, md5($sPassword));
        $query   = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->insert();
    }
}

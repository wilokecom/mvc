<?php declare(strict_types=1);
namespace MVC\Models;

use MVC\Database\DBFactory;

/**
 * Class UserModel
 *
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
     * @return bool
     */
    public static function getUserID($username)
    {
        $aParams = array($username);
        $query = "SELECT * FROM users WHERE username= ? ORDER BY ID LIMIT 1 ";
        $aStatus = self::connect()->prepare($query, $aParams)->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0]["ID"];
    }

    /**
     * @param $ID
     *
     * @return bool
     */
    public static function getUserbyID($ID)
    {
        $aParams = array($ID);
        $query = "SELECT * FROM users WHERE ID = ?";
        $aStatus = self::connect()->prepare($query, $aParams)->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];
    }

    /**
     * @param $userID
     *
     * @return bool
     */
    public static function getUser_metaID($userID)
    {
        $aParams = array($userID);
        $query = "SELECT * FROM user_meta WHERE user_id=? ORDER BY umeta_id LIMIT  1";
        $aStatus = self::connect()->prepare($query, $aParams)->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];
    }
    /**
     * @return bool
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
     * check  username existtance
     * Check whether username exists or not
     *
     * @return bool
     */

    public static function usernameExists($username)
    {
        return self::connect()->prepare("SELECT username FROM users WHERE username=?", array($username))->select();
    }

    /**
     * check  email existtance
     * return array()
     * Check whether username exists or not
     *
     * @return bool
     *
     * @param string $username
     *
     */
    public static function emailExists($username)
    {
        return self::connect()
            ->prepare("SELECT email FROM users WHERE email=?", array($username))->select();
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
    /**
     * @param $fullname
     * @param $fileUpload
     * @param $userID
     *
     * @return mixed
     */
    public static function insertUserMeta($fullname, $fileUpload, $userID)
    {
        $query = "INSERT INTO user_meta (meta_key, meta_value,user_id) VALUES (?,?,$userID) ";
        $aParams = array($fullname, $fileUpload);
        return self::connect()->prepare($query, $aParams)->insert();
    }
    /**
     * @param $meta_key
     * @param $meta_value
     * @param $userID
     *
     * @return bool
     */
    public static function updateUser_meta($meta_key, $meta_value, $userID)
    {
        $aParams = array($meta_key, $meta_value, $userID);
        $query = "UPDATE user_meta SET meta_key = ? , meta_value = ? WHERE user_id = ?";
        $aStatus = self::connect()->prepare($query, $aParams)->update();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];
    }
    /**
     * @param $username
     * @param $password
     * @param $email
     * @param $ID
     *
     * @return bool
     */
    public static function updateUser($username,$email,$password,$ID)
    {
        $aParams = array($username, $email, md5($password),$ID);
        $query = "UPDATE users SET username = ?, email=?, password=? WHERE ID= ?";
        $aStatus = self::connect()->prepare($query,$aParams)->update();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];
    }
}

<?php

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
     * Lấy thông số bảng user thông qua user name
     *
     * @return bool
     *
     * @param $username
     * Done.Thực thi câu lệnh query, trả về kết quả dưới dạng mảng
     */
    public static function getUserByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aParam = array($username);
        $aStatus = self::connect()->prepare($query, $aParam)
            ->select();//Thực thi câu lệnh query và trả về kết quả
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];
    }

    /**
     * @param $username
     *
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
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public static function checkUserLogin($username, $password)//checkUser
    {
        $query = "SELECT * FROM users WHERE username=? AND password=? ORDER BY ID LIMIT 1";
        $aParam = array($username, md5($password));
        $aStatus = self::connect()->prepare($query, $aParam)
            ->select();//Thực thi câu lệnh query và trả về kết quả
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];//Trả về kết qủa dưới dạng mảng
    }

    /**
     * check  username existtance
     * Check whether username exists or not
     *
     * @return bool
     *
     * @param  $username
     */

    public static function usernameExists($username)
    {
        return
            self::connect()->prepare("SELECT username FROM users WHERE username=?", array($username))->select();
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
            ->prepare("SELECT email FROM users WHERE email=?", array($username))
            ->select();
    }

    /**
     * Insert new user
     *
     * @return mixed
     *
     * @param $email
     * @param $password
     * @param $username
     * Nhảy đến phương thức insert() file MysqlGrammar.php
     */
    public static function insertNewUser($username, $email, $password)
    {
        $aParams = array($username, $email, md5($password));
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
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

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
    /*
     * Get User name by User ID
     *
     * @param Int
     * @return array
    */
    //Done.Thực thi câu lệnh query, trả về kết quả dưới dạng mảng
    /**
     * @param $username
     *
     * @return bool
     */
    public static function getUserByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aParam = array($username);

        $aStatus = self::connect()->prepare($query, $aParam)->select();//Thực thi câu lệnh query và trả về kết quả
        if (!$aStatus) {
            return false;
        }

        return $aStatus[0];//Trả về kết qủa dưới dạng mảng

    }

    /**
     * @param $username
     *
     * @return bool
     */
    public static function getUserID($username)
    {
        $aParams = array($username);
        $query = "SELECT * FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aStatus = self::connect()->prepare($query, $aParams)->select();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0]["ID"];
    }
    /**
     * Check whether username exists or not
     *
     * @param string $username
     *
     * @return bool
     */
    //Kiểm tra username có tồn tại hay không
    //Trả về mảng
    public static function usernameExists($username)
    {
        return self::connect()->prepare("SELECT username FROM users WHERE username=?", array($username))->select();
    }

    /**
     * Check whether username exists or not
     *
     * @param string $username
     *
     * @return bool
     */
    //Kiểm tra email có tồn tại hay không
    //Trả về mảng
    public static function emailExists($username)
    {
        return self::connect()->prepare("SELECT email FROM users WHERE email=?", array($username))->select();
    }

    /**
     * @param string $username
     * @param $email
     * @param $password
     * Insert new user
     * @return mixed
     *              Check whether username exists or not
     */
    public static function insertNewUser($username, $email, $password)
    {
        $aParams = array($username, $email, md5($password));
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        return self::connect()->prepare($query, $aParams)->insert();

    }

    /**
     * @param $username
     * @param $password
     * Kiểm tra users
     * thực thi câu lệnh query tìm đến người dùng đăng nhập
     * @return bool
     */
    public static function checkUser($username, $password)
    {
        $query = "SELECT * FROM users WHERE username=? AND password=? ORDER BY ID LIMIT 1";
        $aParam = array($username, md5($password));
        $aStatus = self::connect()->prepare($query, $aParam)->select();//Thực thi câu lệnh query và trả về kết quả
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];//Trả về kết qủa dưới dạng mảng
    }

    /**
     * @param $fullname
     * @param $fileUpload
     * @param $userID
     *
     * @return mixed
     */
    public  static function insertUserMeta($fullname, $fileUpload,$userID)
    {
        $query = "INSERT INTO user_meta (meta_key, meta_value,user_id) VALUES (?,?,$userID) ";
        $aParams = array($fullname,$fileUpload);
        return self::connect()->prepare($query,$aParams)->insert();
    }
}

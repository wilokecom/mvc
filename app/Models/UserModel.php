<?php

namespace MVC\Models;


use MVC\Database\DBFactory;
use MVC\Support\Session;

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
     * @param $ID
     * @return bool
     */
    public static function getUserByID($ID)
    {
        $query = "SELECT * FROM users WHERE ID=? "; //ORDER ID LIMIT 1
        $aParam = array($ID);
        $aStatus = self::connect()->prepare($query,$aParam)->select();
        if (!$aStatus){
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
     * @param        $email
     * @param        $password
     * Insert new user
     *
     * @return mixed
     * Check whether username exists or not
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
     *
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
    public static function insertUserMeta($fullname, $fileUpload, $userID)
    {
        $query = "INSERT INTO user_meta (meta_key, meta_value,user_id) VALUES (?,?,$userID) ";
        $aParams = array($fullname, $fileUpload);
        return self::connect()->prepare($query, $aParams)->insert();
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
//        var_dump($query);
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
        $query = "UPDATE users SET username = ?, email=?, password=? WHERE ID=?";
        $aStatus = self::connect()->prepare($query,$aParams)->update();
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];
    }

    public static function getField($metaKey, $userID)
    {
        "Select meta_value From usermeta where meta_key='" . $metaKey . "' AND user_id=" . $userID;
    }

//    public static function getEmail($userID)
//    {
//        "Select * From usermeta where user_id=" . $userID;
// ORDER BY umeta_id LIMIT  1
//        array(
//            'profile' => '',
//            'email' => ''
//        )
//    }
}


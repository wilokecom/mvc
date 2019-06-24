<?php
namespace MVC\Models;

use MVC\Database\DBFactory;

/**
 * Class UserModel
 * @package MVC\Models
 */
class UserModel extends DBFactory
{
    /**
     * Lấy thông số bảng user thông qua user name
     * @return bool
     * @param $username
     */
    public static function getUserByUsername($username)//Done.Thực thi câu lệnh query, trả về kết quả dưới dạng mảng
    {
        $query = "SELECT * FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aParam = array($username);
        $aStatus = self::connect()->prepare($query, $aParam)
            ->select();//Thực thi câu lệnh query và trả về kết quả
        if (!$aStatus) {
            return false;
        }
        return $aStatus[0];//Trả về kết qủa dưới dạng mảng
    }
    /**
     * Lấy thông số bảng user thông qua username và passwword
     * @return bool
     * @param $password
     * @param $username
     */
    public static function checkUser($username, $password)//checkUser
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
     * Kiểm tra username có tồn tại hay không
     * Check whether username exists or not
     * @return bool
     * @param string $username
     */
    //Kiểm tra username có tồn tại hay không
    //Trả về mảng
    public static function usernameExists($username)
    {
        return self::connect()->prepare("SELECT username FROM users WHERE username=?", array($username))->select();
    }
    /**
     * Kiểm tra email có tồn tại hay không
     * Trả về mảng
     * Check whether username exists or not
     * @return bool
     * @param string $username
     */
    public static function emailExists($username)//Kiểm tra email có tồn tại hay không
    {
        return self::connect()
            ->prepare("SELECT email FROM users WHERE email=?", array($username))
            ->select();
    }
    /**
     * Insert new user
     * @return mixed
     * @param $email
     * @param $password
     * @param $username
     */
    public static function insertNewUser($username, $email, $password)//Insert new user
    {
        $aParams = array($username, $email, md5($password));
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        //Nhảy đến phương thức insert() file MysqlGrammar.php
        return self::connect()->prepare($query, $aParams)->insert();
    }
}

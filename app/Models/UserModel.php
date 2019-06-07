<?php

namespace MVC\Models;


use MVC\Database\DBFactory;

class UserModel extends DBFactory {

	/*
	 * Get User name by User ID
	 *
	 * @param Int
	 * @return array
	 */
	// public static function getUserById($userID)
 //    {
	// 	return self::connect()->queryPrepared("SELECT * FROM users WHERE ID=?", array($userID));
	// }
	// public static function registerUser($username,$password,$email)
 //    {
 //        return self::connect()->queryPrepared("INSERT INTO users(username,password,email,) VALUES ('{$username}','{$password}','{$email}')");
 //    }
    /*
     * Get User name by User ID
     *
     * @param Int
     * @return array
    */
    public static function getUserByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username=? ORDER BY ID LIMIT 1";
        $aParam = array($username);

        $aStatus = self::connect()->prepare($query, $aParam)->select();
        if (!$aStatus) {
            return false;
        }

        return $aStatus[0];
    }

    /**
     * Check whether username exists or not
     *
     * @param string $username
     *
     * @return bool
     */
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
    public static function emailExists($username)
    {
        return self::connect()->prepare("SELECT email FROM users WHERE email=?", array($username))->select();
    }


    /**
     * Check whether username exists or not
     *
     * @param string $username
     *
     * @return bool
     */
    public static function insertNewUser($username, $email, $password)
    {
        $aParams = array($username, $email, md5($password));
        $query   = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        return self::connect()->prepare($query, $aParams)->insert();
    }
}
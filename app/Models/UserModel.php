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
    public static function getUserById($userID)
    {
        //Nhảy đến phương thức connect-file MVC\Database\DBFactory;
        return self::connect()->prepare("SELECT * FROM users WHERE ID=?", array($userID));
    }
    public static function registerUser($username,$password,$email)
    {
        return self::connect()->queryPrepared("INSERT INTO users(username,password,email,) VALUES ('{$username}','{$password}','{$email}')");
    }
}

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
	public static function getUserById($userID){
		return self::connect()->select("SELECT * FROM users WHERE ID=".$userID);
	}
}
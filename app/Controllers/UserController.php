<?php

namespace MVC\Controllers;


use MVC\Models\UserModel;

class UserController extends Controller {
	public function index(){
		var_export(UserModel::getUserById(1));
	}
}
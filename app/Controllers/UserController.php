<?php

namespace MVC\Controllers;


use MVC\Models\UserModel;

class UserController extends Controller {
	public function login(){
		//var_export(UserModel::getUserById(1));
        //Khởi tạo Session
        //Nếu đã login rồi thì chuyển sang trang POST
        if(isset($_POST['submit'])) {
            $source = array('username' => $_POST['username']);//Validate
            $username 	= $_POST['username'];
            // Mã hóa dữ liệu theo kiểu MD5
            $password 	= md5($_POST['password']);
        }
        $this->loadView('user/login');
        UserModel::getUserById(1);
	}
	public function logout(){
        $this->loadView('user/logout');
    }
    public function register(){
        //var_export(UserModel::getUserById(1));
        $this->loadView('user/register');
    }
    public function post (){
        $this->loadView('user/post');
    }
    public function handleRegister(){//Xử lý đăng nhập
        if ( empty($_POST) ){
            header('Location: ' . MVC_HOME_URL . '/user/register');
            exit;
        }else{
            var_dump($_POST);die;
        }
    }
    public function handleLogin(){
        if ( empty($_POST) ){
            header('Location: ' . MVC_HOME_URL . '/user/login');
            exit;
        }
        else{
            var_dump($_POST);die;
        }
    }
}
<?php

namespace MVC\Controllers;

use MVC\Core\Session;
use MVC\Models\UserModel;


class UserController extends Controller
{
//	public function index(){
//		var_export(UserModel::getUserById(1));
//		session::init();
//	}

    public function login()
    {

        if(Session::get('loggedIn')==true){
            $this->redirect('users','login');
        }
        $this->loadView('users/login');
    }

    public function Register(){
        $this->loadView('users/register');
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

    public function handleRegister(){
//        if ( empty($_POST) )
//        {
//            header('Location: ' . MVC_HOME_URL . '/user/register');
//            exit;
//        }
//        else
//        {
//            var_dump($_POST);die;
          var_export(UserModel::registerUser('cuong','aaaa','cuong@gmail.com'));
           // session::init();
//            if($_POST['username'])
//            {
//                $username = $_POST['username'];
//            }
//            if($_POST['password'])
//            {
//                $password = $_POST['password'];
//            }
//            if($_POST['email'])
//            {
//                $email = $_POST['email'];
//            }

    //    }
    }

//    public function login1(){
//
//        if(Session::get('loggedIn')==true){
//            $this->redirect('home','login');
//        }
//
//        if(isset($_POST['submit'])){
//            $source 	= array('username' => $_POST['username']);
//            $username 	= $_POST['username'];
//            $password 	= md5($_POST['password']);
//            $validate = new Validate($source);
//
//            $validate->addRule('username', 'existRecord', array('database' => $this->db, 'query' => "SELECT `id` FROM `user` WHERE `username` = '$username' AND `password` = '$password'"));
//
//            $validate->run();
//            if($validate->isValid()==true){
//                Session::set('loggedIn', true);
//                $this->redirect('group','index');
//            }else{
//                $this->view->errors = $validate->showErrors();
//            }
//        }
//
//        $this->view->render('user/login');
//    }

    public function logout(){
        $this->view->render('user/logout');
        Session::destroy();
    }

}

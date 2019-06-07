<?php

namespace MVC\Controllers;


use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;

class UserController extends Controller {
    /**
     * @var string $loginSessionKey
     */
    protected static $loginSessionKey = 'user_logged_in';

    public function login()
    {
        $this->loadView('user/login');
    }

    public function register()
    {
        $this->loadView('user/register');
    }

    public function dashboard()
    {
        if (!self::isLoggedIn()) {
            Redirect::to('user/register');
        }

        $aUserInfo = UserModel::getUserByUsername($_SESSION[self::$loginSessionKey]);
        $this->loadView('user/dashboard', $aUserInfo);
    }

    public static function isLoggedIn() {
        return Session::has(self::$loginSessionKey);
    }

    public function handleLogout(){
        Session::forget(self::$loginSessionKey);
        Redirect::to('user/login');
    }

    public function handleRegister()
    {
        $status = Validator::validate(
            array(
                'username' => 'required|maxLength:50',
                'email'    => 'required|maxLength:100',
                'password' => 'required'
            ),
            $_POST
        );

        if ($status !== true) {
            Session::add('register_error', $status);
            Redirect::to('user/register');
        }

        if (UserModel::emailExists($_POST['email'])) {
            Session::add('register_error', 'Oops! This email is already exist');
            Redirect::to('user/register');
        }

        if (UserModel::usernameExists($_POST['username'])) {
            Session::add('register_error', 'Oops! This username is already exist');
            Redirect::to('user/register');
        }

        $status = UserModel::insertNewUser($_POST['username'], $_POST['email'], $_POST['password']);
        if (!$status) {
            Session::add('register_error', 'Oops! Something went error');
            Redirect::to('user/register');
        }

        Session::add('user_logged_in', $_POST['username']);

        Session::forget('register_error');
        Redirect::to('user/dashboard');
    }

    public function handleLogin()
    {

    }
}

<?php

namespace MVC\Controllers;

use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;

class UserController extends Controller
{
    /**
     * @var string $loginSessionKey
     */
    protected static $loginSessionKey = 'user_logged_in';
    //Phương thức mặc định, url:/mvc/user/
    public function index(){
        //Nếu chưa đăng nhập
        $this->redirectToUserLogin();
        //Nếu đã đăng nhập
        $this->redirectToDashboard();
    }
    //Phương thức login-Hiển thị giao diện
    public function login()
    {
        $this->redirectToDashboard();//Nếu đã login thì chuyển đến trang dashboard
        $this->loadView('user/login');
    }
    //Phương thức register-Hiển thị giao diện
    public function register()
    {
        $this->redirectToDashboard();////Nếu đã login thì chuyển đến trang dashboard
        $this->loadView('user/register');
    }
    //Chuyển về trang user/login
    public function redirectToUserLogin(){
        if (!self::isLoggedIn()) {
            Redirect::to('user/login');
        }
    }
  
    public function redirectToDashboard(){
        if(self::isLoggedIn()) {
            Redirect::to('user/dashboard');
        }
    }
    //Phương thức dashboard()-Sau khi login thành công-Hiển thị giao diện
    public function dashboard()
    {
        //Nếu chưa đăng nhập chuyển về trang login
        $this->redirectToUserLogin();

        $aUserInfo = UserModel::getUserByUsername($_SESSION[self::$loginSessionKey]);
        $this->loadView('user/dashboard', $aUserInfo);
    }
    //Kiểm tra đã loggin chưa
    public static function isLoggedIn()
    {
        return Session::has(self::$loginSessionKey);
    }
    //Xử lý khi nhấn logout
    public function handleLogout()
    {
        //Hủy Session Login
        Session::forget(self::$loginSessionKey);
        //Chuyển đến trang Login
        Redirect::to('user/login');
    }
    //Xủ lý khi nhấn submit
    public function handleRegister()
    {
        //Nhảy đến ClassLoader.php, require file Validator.php, xử lý phương thức validate
        //Kiểm tra-nếu có lỗi thì hiển thị thông báo lỗi, nếu không có thì bỏ qua
        $status = Validator::validate(
            array(
                'username' => 'required|maxLength:50',
                'email' => 'required|maxLength:100',
                'password' => 'required'
            ),
            $_POST
        );
        //Nếu có lỗi, khởi tạo và add Session, chuyển về đường dẫn user/register
        if ($status !== true) {
            Session::add('register_error', $status);
            Redirect::to('user/register');
        }
        //Kiểm tra email có tồn tại hay không
        //Include file UserModel extend DB Factory--> include DB Factory
        //Nhảy đến phương thức UserModel::emailExists
        if (UserModel::emailExists($_POST['email'])) {
            Session::add('register_error', 'Oops! This email is already exist');
            Redirect::to('user/register');
        }
        //Nhảy đến phương thức UserModel::usernameExists
        if (UserModel::usernameExists($_POST['username'])) {
            Session::add('register_error', 'Oops! This username is already exist');
            Redirect::to('user/register');
        }
        ////Nhảy đến phương thức UserModel::insertNewUser
        $aStatus = UserModel::insertNewUser($_POST['username'], $_POST['email'], $_POST['password']);
        if (!$aStatus) {
            Session::add('register_error', 'Oops! Something went error');
            Redirect::to('user/register');
        }
        Session::add(self::$loginSessionKey, $_POST['username']);//include file app/Support/Session.php, lưu username biến $Session
        Session::forget('register_error');
        Redirect::to('user/dashboard');//Include file app/Support/redirect
    }
    //Xử lý khi nhấn loggin
    public function handleLogin()
    {
        $status = Validator::validate(
            array(
                'username' => 'required|maxLength:50',
                //'email' => 'required|maxLength:100',
                'password' => 'required'
            ),
            $_POST
        );
        if ($status !== true) {
            Session::add('login_error', $status);
            Redirect::to('user/login');
        }
        $aStatus = UserModel::checkUser($_POST['username'], $_POST['password']);

        if ($aStatus != true) {
            Session::add('login_error', 'invalid username or password');
            Redirect::to('user/login');
        }
        //Thêm Session[$loginSessionKey]=$_POST['username']
        Session::add(self::$loginSessionKey, $_POST['username']);
        //Destroy error

        Session::forget('login_error');
        Redirect::to('user/dashboard');
    }
}

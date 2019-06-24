<?php
namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;

/**
 * Class UserController
 * @package MVC\Controllers
 */
class UserController extends Controller
{
    /**
     * Biến lưu Session user login
     * @var string
     */
    protected static $loginSessionKey = "user_logged_in";
    /**
     * Phương thức mặc định, url:/mvc/user/
     */
    public function index()//Phương thức mặc định, url:/mvc/user/
    {
        //Nếu chưa đăng nhập
        $this->redirectToUserLogin();
        //Nếu đã đăng nhập
        $this->redirectToDashboard();
    }
    /**
     * Phương thức login-Hiển thị giao diện
     * @throws \Exception
     */
    public function login()//Login
    {
        $this->redirectToDashboard();
        $this->loadView("user/login");
    }
    /**
     * Phương thức register-Hiển thị giao diện
     * @throws \Exception
     */
    public function register()//Phương thức register-Hiển thị giao diện
    {
        $this->redirectToDashboard();
        $this->loadView("user/register");
    }
    /**
     * Chuyển về trang user/login
     */
    public function redirectToUserLogin() //Chuyển về trang user/login
    {
        if (!self::isLoggedIn()) {
            Redirect::to("user/login");
        }
    }
    /**
     * Chuyển về trang dashboard
     */
    public function redirectToDashboard()//Chuyển về trang dashboard
    {
        if (self::isLoggedIn()) {
            Redirect::to("user/dashboard");
        }
    }
    /**
     * Phương thức dashboard()-Sau khi login thành công-Hiển thị giao diện
     * @throws \Exception
     */
    public function dashboard()
    {
        //Nếu chưa đăng nhập chuyển về trang login
        $this->redirectToUserLogin();
        //Lấy thông tin bảng User
        $aUserInfo = UserModel::getUserByUsername(
            $_SESSION[self::$loginSessionKey]
        );
        //Lấy thông tin bảng Post
        $aPosts = PostModel::getPostbyPostAuthor($aUserInfo["ID"]);
        if (!$aPosts) { //Nếu $aPosts=false thì trả về mảng rỗng
            $aPosts = array();
        }
        $aData = array_merge($aUserInfo, $aPosts);
        $this->loadView("user/dashboard", $aUserInfo, $aPosts);
    }
    /**
     * Kiểm tra đã loggin chưa
     * @return bool
     */
    public static function isLoggedIn()//Kiểm tra đã loggin chưa
    {
        return Session::has(self::$loginSessionKey);
    }
    /**
     * Xử lý khi nhấn logout
     */
    public function handleLogout()//Xử lý khi nhấn logout
    {
        //Hủy Session Login
        Session::forget(self::$loginSessionKey);
        //Chuyển đến trang Login
        Redirect::to("user/login");
    }
    /**
     * Xử lý handleRegister
     */
    public function handleRegister()//Xủ lý khi nhấn submit
    {
        //Nhảy đến ClassLoader.php, require file Validator.php, xử lý phương thức validate
        //Kiểm tra-nếu có lỗi thì hiển thị thông báo lỗi, nếu không có thì bỏ qua
        $status = Validator::validate(
            array(
                "username" => "required|maxLength:50",
                "email" => "required|maxLength:100",
                "password" => "required",
                "agree_term" => "required"
            ),
            $_POST
        );
        //Nếu có lỗi, khởi tạo và add Session, chuyển về đường dẫn
        if ($status !== true) {
            Session::add("register_error", $status);
            Redirect::to("user/register");
        }
        //Kiểm tra email có tồn tại hay không
        //Include file UserModel extend DB Factory--> include DB Factory
        //Nhảy đến phương thức UserModel::emailExists
        if (UserModel::emailExists($_POST["email"])) {
            Session::add("register_error", "Oops! This email is already exist");
            Redirect::to("user/register");
        }
        //Nhảy đến phương thức UserModel::usernameExists
        if (UserModel::usernameExists($_POST["username"])) {
            Session::add("register_error", "Oops! This username is already exist");
            Redirect::to("user/register");
        }
        ////Nhảy đến phương thức UserModel::insertNewUser
        $aStatus = UserModel::insertNewUser($_POST["username"], $_POST["email"], $_POST["password"]);
        if (!$aStatus) {
            Session::add("register_error", "Oops! Something went error");
            Redirect::to("user/register");
        }
        //include file app/Support/Session.php, lưu username biến $Session
        Session::add(self::$loginSessionKey, $_POST["username"]);
        Session::forget("register_error");
        Redirect::to("user/dashboard");//Include file app/Support/redirect
    }
    /**
     * Xử lý phương thước handleLogin
     */
    public function handleLogin()
    {
        //$userID = UserModel::getUserID($username);
        //$aPosts = PostModel::getPost($userID);
        $status = Validator::validate(
            array(
                "username" => "required|maxLength:50",
                //"email" => "required|maxLength:100",
                "password" => "required"
            ),
            $_POST
        );
        if ($status !== true) {
            Session::add("login_error", $status);
            Redirect::to("user/login");
        }
        $aStatus = UserModel::checkUser($_POST["username"], $_POST["password"]);
        if ($aStatus != true) {
            Session::add("login_error", "invalid username or password");
            Redirect::to("user/login");
        }
        //Thêm Session[$loginSessionKey]=$_POST["username"]
        Session::add(self::$loginSessionKey, $_POST["username"]);
        //Destroy error
        Session::forget("login_error");
        Redirect::to("user/dashboard");//Include file app/Support/redirec
    }
}

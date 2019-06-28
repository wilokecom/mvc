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
     * Save Session
     * @var string
     */
    public static $loginSessionKey = "user_logged_in";
    /**
     * Default method, url:/mvc/user/
     */
    public function index()
    {
        //If not logined
        self::redirectToUserLogin();
        //If logined
        self::redirectToDashboard();
    }
    /**
     *  Login method-Show Interface
     *  If logined, ruturn user/dashboard
     *  If not logined, return user/login
     * @throws \Exception
     */
    public function login()
    {
        self::redirectToDashboard();
        $this->loadView("user/login");
    }
    /**
     * Phương thức register-Show Interface
     * @throws \Exception
     */
    public function register()
    {
        self::redirectToDashboard();
        $this->loadView("user/register");
    }
    /**
     * If not logined, returned to user/login
     */
    public static function redirectToUserLogin()
    {
        if (!self::isLoggedIn()) {
            Redirect::to("user/login");
        }
    }
    /**
     * Return to dashboard
     */
    public static function redirectToDashboard()
    {
        if (self::isLoggedIn()) {
            Redirect::to("user/dashboard");
        }
    }
    /**
     * @param $aParam
     * @throws \Exception
     */
    public function dashboard($aParam)
    {
        self::redirectToUserLogin();
        $total_records = PostModel::getRecordbyPostAuthor();
        // current page and start
        $current_page = isset($aParam[2]) ? explode("-", $aParam[2])[1] : 1;
        unset($aParam[2]);
        $limit = 4;
        //Total page
        $total_page = (ceil($total_records / $limit) > 0) ? ceil(
            $total_records / $limit
        ) : 1;
        if ($current_page > $total_page) {
            $current_page = $total_page;
        } elseif ($current_page < 1) {
            $current_page = 1;
        }
        //start
        $start = ($current_page - 1) * $limit;
        $aUserInfo = UserModel::getUserByUsername(
            $_SESSION[self::$loginSessionKey]
        );
        $aPostInfo = PostModel::getPostbyPostAuthor1($aUserInfo["ID"], $start, $limit);
        //If $aPosts=false, return empty array
        if (!$aPostInfo) {
            $aPostInfo = array();
        }
        $this->loadView("user/dashboard", $aUserInfo, $aPostInfo, $current_page, $total_page);
    }
    /**
     * Check logined or not
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Session::has(self::$loginSessionKey);
    }
    /**
     * Handle when press logout
     * Destroy Session Login
     * Return to user/login
     */
    public function handleLogout()
    {
        Session::forget(self::$loginSessionKey);
        Redirect::to("user/login");
    }
    /**
     * Handle Register, when press submit
     */
    public function handleRegister()
    {
        $status = Validator::validate(
            array(
                "username" => "required|maxLength:50",
                "email" => "required|maxLength:100",
                "password" => "required",
                "agree_term" => "required"
            ),
            $_POST
        );
        //If has error, add error to Session, return to user/register
        if ($status !== true) {
            Session::add("register_error", $status);
            Redirect::to("user/register");
        }
        //Check email is exist or not
        if (UserModel::emailExists($_POST["email"])) {
            Session::add("register_error", "Oops! This email is already exist");
            Redirect::to("user/register");
        }
        //Check username is exist or not
        if (UserModel::usernameExists($_POST["username"])) {
            Session::add("register_error", "Oops! This username is already exist");
            Redirect::to("user/register");
        }
        //Inser new user to user table
        $aStatus = UserModel::insertNewUser($_POST["username"], $_POST["email"], $_POST["password"]);
        if (!$aStatus) {
            Session::add("register_error", "Oops! Something went error");
            Redirect::to("user/register");
        }
        //Save username to Session["user_logged_in"]
        Session::add(self::$loginSessionKey, $_POST["username"]);
        Session::forget("register_error");//delete Session
        Redirect::to("user/dashboard");
    }
    /**
     * handleLogin-After login
     */
    public function handleLogin()
    {
        //Validate
        $status = Validator::validate(
            array(
                "username" => "required|maxLength:50",
                "password" => "required"
            ),
            $_POST
        );
        if ($status !== true) {
            Session::add("login_error", $status);
            Redirect::to("user/login");
        }
        $aStatus = UserModel::checkUserLogin($_POST["username"], $_POST["password"]);
        if ($aStatus != true) {
            Session::add("login_error", "invalid username or password");
            Redirect::to("user/login");
        }
        //Thêm Session[$loginSessionKey]=$_POST["username"]
        Session::add(self::$loginSessionKey, $_POST["username"]);
        //Destroy error
        Session::forget("login_error");
        Redirect::to("user/dashboard");
    }
}

<?php
namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;
use MVC\Support\Upload;

/**
 * Class UserController
 * @package MVC\Controllers
 */
class UserController extends Controller
{
    /**
     * variable saves Session user login
     * @var string
     */
    public static $loginSessionKey = "user_logged_in";
    /**
     * default method, url:/mvc/user/
     * if loged in !
     * if doesn't log in
     */
    public function index()
    {
        self::redirectToUserLogin();
        self::redirectToDashboard();
    }
    /**
     * method login-display
     * load view if logged in
     * @throws \Exception
     */
    public function login()
    {
        self::redirectToDashboard();
        $this->loadView("user/login");
    }
    /**
     * method register-display
     * @throws \Exception
     */
    public function register()
    {
        self::redirectToDashboard();
        $this->loadView("user/register");
    }
    /**
     * redirect user/login
     */
    public static function redirectToUserLogin()
    {
        if (!self::isLoggedIn()) {
            Redirect::to("user/login");
        }
    }
    /**
     * redirect dashboard
     */
    public static function redirectToDashboard()
    {
        if (self::isLoggedIn()) {
            Redirect::to("user/dashboard");
        }
    }
    /**
     * if wasn't log in then redirect login page
     *  //get info from user table
     * url:user/dashboard
     * get info from post table
     * Method dashboard()-after login success- displays
     * $aData = array_merge($aUserInfo, $aPostInfo);
     * @throws \Exception
     */
    public function dashboard()
    {
        self::redirectToUserLogin();
        $iID = Session::get(self::$loginSessionKey);
        $aUserInfo = UserModel::getUserbyID($iID);
        $aPostInfo = PostModel::getPostbyPostAuthor($iID);
        $aPostRecord = PostModel::getRecordbyPostAuthor($iID);
        if (!$aPostInfo) {
            $aPostInfo = array();
            $this->loadView('');
        }
        $this->loadView(
            "user/dashboard",
            $aUserInfo,
            $aPostInfo
        );
    }
    /**
     * Checked Logged in
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Session::has(self::$loginSessionKey);
    }
    /**
     * Solving logout
     * Destroy  Login Session
     * redirect Login page
     */
    public function handleLogout()
    {
        Session::forget(self::$loginSessionKey);
        Redirect::to("user/login");
    }
    /**
     * Solving handleRegister when submit
     * Run into ClassLoader.php , required file Validator , solving method
     * validate Check and display error
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
        if ($status !== true) {
            Session::add(
                "register_error",
                $status
            );
            Redirect::to("user/register");
        }
        if (UserModel::emailExists($_POST["email"])) {
            Session::add(
                "register_error",
                "Oops! This email is already exist"
            );
            Redirect::to("user/register");
        }
        if (UserModel::usernameExists($_POST["username"])) {
            Session::add(
                "register_error",
                "Oops! This username is already exist"
            );
            Redirect::to("user/register");
        }
        $aStatus = UserModel::insertNewUser(
            $_POST["username"],
            $_POST["email"],
            $_POST["password"]
        );
        if (!$aStatus) {
            Session::add(
                "register_error",
                "Oops! Something went error"
            );
            Redirect::to("user/register");
        }
        Session::add(
            self::$loginSessionKey,
            UserModel::getUserID($_POST['username'])
        );
        Session::forget("register_error");
        Redirect::to("user/dashboard");
    }
    /**
     * Solving method handleLogin
     * Adding Session[$loginSessionKey]=$_POST["username"]
     * Destroy error
     */
    public function handleLogin()
    {
        $status = Validator::validate(
            array(
                "username" => "required|maxLength:50",
                "password" => "required"
            ),
            $_POST
        );
        if ($status !== true) {
            Session::add(
                "login_error",
                $status
            );
            Redirect::to("user/login");
        }
        $aStatus = UserModel::checkUser(
            $_POST["username"],
            $_POST["password"]
        );
        if ($aStatus != true) {
            Session::add(
                "login_error",
                "invalid username or password"
            );
            Redirect::to("user/login");
        }
        Session::add(
            self::$loginSessionKey,
            UserModel::getUserID($_POST['username'])
        );
        Session::forget('register_error');
        Redirect::to('user/dashboard');
    }
    /**
     * @throws \Exception
     */
    public function profile()
    {
        if (!self::isLoggedIn()) {
            Redirect::to('user/login');
        }
        $iID       = Session::get(self::$loginSessionKey);
        $aUserInfo = UserModel::getUserByID($iID);
        $aName     = UserModel::getUserMetaID($iID);
        if (!$aName) {
            $aName = array();
            $this->loadView(
                'user/profile',
                $aUserInfo
            );
        }
        $this->loadView(
            'user/profile',
            $aUserInfo,
            $aName
        );
    }
    /**
     * @throws \Exception
     * Check the editProfile URL ,
     * if not yet logged in then don't into the edit-profile
     */
    public function editProfile()
    {
        if (!self::isLoggedIn()) {
            Redirect::to('user/login');
        }
        $aName     = UserModel::getUserMetaID(
            Session::get(self::$loginSessionKey)
        );
        $aUserInfo = UserModel::getUserByID(
            Session::get(self::$loginSessionKey)
        );
        if (!$aName) {
            $aName = array();
            $this->loadView(
                'user/edit-profile',
                $aUserInfo
            );
        } else {
            $this->loadView(
                'user/edit-profile',
                $aUserInfo,
                $aName
            );
        }
    }
    /**
     *
     */
    public function handleEditProfile()
    {
        $iID   = Session::get(self::$loginSessionKey);
        $aName = UserModel::getUserMetaID($iID);
        if (!$aName) {
            $this->upload();
        }
        $fileUpload = Upload::upload('file-upload');
        /**
         * if the name of  file upload not null
         */
        if ($fileUpload['name'] == null) {
            $fileUpload['name'] = $aName['meta_value'];
        }
        $aUserInfo = UserModel::getUserByID($iID);
        $aData     = array_merge(
            $_POST,
            $fileUpload
        );
        $status    = Validator::validate(
            array(
                'fullname' => 'required|maxLength:50',
                'name' => 'maxLength:50',
                'username' => 'required|maxLength:50',
                'password' => 'required|maxLength:50',
                'email' => 'required|maxLength:50'
            ),
            $aData
        );
        if ($status !== true) {
            Session::add(
                'edit-profile_error',
                $status
            );
            Redirect::to('user/edit-profile');
        }
        $aStatus  = UserModel::updateUsermeta(
            $aData['fullname'],
            $aData['name'],
            $iID
        );
        $aStatus2 = UserModel::updateUser(
            $aData['username'],
            $aData['email'],
            $aData['password'],
            $iID
        );
        Session::forget('login_error');
        Redirect::to('user/profile');
    }
    /**
     * If the name of file-upload not
     *
     */
    public function upload()
    {
        $fileUpload = Upload::upload('file-upload');
        $aData      = array_merge(
            $_POST,
            $fileUpload
        );
        $status     = Validator::validate(
            array(
                'fullname' => 'required|maxLength:50',
                'name' => 'required|maxLength:50',
                'type' => 'required|checkType',
                'destination' => 'required|maxLength:100'
            ),
            $aData
        );
        if ($status !== true) {
            Session::add(
                'edit-profile_error',
                $status
            );
            Redirect::to('user/edit-profile');
        }
        $iID         = Session::get(self::$loginSessionKey);
        $astatusUser = UserModel::insertUserMeta(
            $aData['fullname'],
            $aData['name'],
            $iID
        );
        if (!$astatusUser) {
            Session::add(
                'edit-profile_error',
                'Oops! Something went error'
            );
            Redirect::to('user/edit-profile');
        }
        Redirect::to('user/profile');
    }
}

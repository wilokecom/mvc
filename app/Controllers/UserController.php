<?php

namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;

/**
 * Class UserController
 *
 * @package MVC\Controllers
 */
class UserController extends Controller
{
    /**
     * Biến lưu Session user login
     *
     * @var string
     */
    public static $loginSessionKey = "user_logged_in";

    /**
     * Phương thức mặc định, url:/mvc/user/
     * if loged in !
     * if doesn't log in
     */
    public function index()
    {

        self::redirectToUserLogin();
        self::redirectToDashboard();
    }

    /**
     * Phương thức login-Hiển thị giao diện
     * load view if logged in
     *
     * @throws \Exception
     */
    public function login()//Login
    {
        self::redirectToDashboard();

        $this->loadView("user/login");
    }

    /**
     * Phương thức register-Hiển thị giao diện
     *
     * @throws \Exception
     */
    public function register()
    {
        self::redirectToDashboard();
        $this->loadView("user/register");
    }

    /**
     * Chuyển về trang user/login
     */
    public static function redirectToUserLogin()
    {
        if (!self::isLoggedIn()) {
            Redirect::to("user/login");
        }
    }

    /**
     * Chuyển về trang dashboard
     */
    public static function redirectToDashboard()
    {
        if (self::isLoggedIn()) {
            Redirect::to("user/dashboard");
        }
    }

    /**
     * //Nếu chưa đăng nhập chuyển về trang login
     *  //get info from user table
     * url:user/dashboard
     * get info from post table
     * Phương thức dashboard()-Sau khi login thành công-Hiển thị giao diện
     *        //$aData = array_merge($aUserInfo, $aPostInfo);
     *
     * @throws \Exception
     */
    public function dashboard()
    {

        self::redirectToUserLogin();

        $aUserInfo = UserModel::getUserByUsername(
            $_SESSION[self::$loginSessionKey]
        );
        $aPostInfo = PostModel::getPostbyPostAuthor($aUserInfo["ID"]);
        if (!$aPostInfo) {
            $aPostInfo = array();
        }
        $this->loadView("user/dashboard", $aUserInfo, $aPostInfo);
    }

    /**
     * Checked Logged in
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Session::has(self::$loginSessionKey);
    }

    /**
     * Solving logout
     * Destroy  Login Session
     * Chuyển đến trang Login
     */
    public function handleLogout()
    {
        Session::forget(self::$loginSessionKey);
        Redirect::to("user/login");
    }

    /**
     * Solving handleRegister when submit
     * Run into ClassLoader.php , required file Validator , solving method validate
     * Check and display error
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
            Session::add("register_error", $status);
            Redirect::to("user/register");
        }


        if (UserModel::emailExists($_POST["email"])) {
            Session::add("register_error", "Oops! This email is already exist");
            Redirect::to("user/register");
        }

        if (UserModel::usernameExists($_POST["username"])) {
            Session::add("register_error", "Oops! This username is already exist");
            Redirect::to("user/register");
        }


        $aStatus = UserModel::insertNewUser($_POST["username"], $_POST["email"], $_POST["password"]);
        if (!$aStatus) {
            Session::add("register_error", "Oops! Something went error");
            Redirect::to("user/register");
        }

        Session::add(self::$loginSessionKey, UserModel::getUserID($_POST['username']));
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
            Session::add("login_error", $status);
            Redirect::to("user/login");
        }
        $aStatus = UserModel::checkUser($_POST["username"], $_POST["password"]);
        if ($aStatus != true) {
            Session::add("login_error", "invalid username or password");
            Redirect::to("user/login");
        }

        Session::add(self::$loginSessionKey, UserModel::getUserID($_POST['username']));//include file app/Support/Session.php, lưu username biến $Session
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
        $ID = Session::get(self::$loginSessionKey);
        $aUserInfo = UserModel::getUserByID($ID);
        $aName = UserModel::getUser_metaID($ID);

        if (!$aName) {
            $aName = array();
            $this->loadView('user/profile', $aUserInfo);
        }
        $aData = array_merge($aUserInfo, $aName);
        $this->loadView('user/profile', $aData);
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

        $aName = UserModel::getUser_metaID(Session::get(self::$loginSessionKey));

        $aUserInfo = UserModel::getUserByID(Session::get(self::$loginSessionKey));
        if (!$aName) {
            $aName = array();
            $this->loadView('user/edit-profile', $aUserInfo);
            var_dump($aUserInfo);
        } else {
            $aData = array_merge($aUserInfo, $aName);
            $this->loadView('user/edit-profile', $aData);
        }
        $aData = array_merge($aUserInfo, $aName);
    }

    /**
     *
     */
    public function handleEditProfile()
    {
        $ID = Session::get(self::$loginSessionKey);
        $aName = UserModel::getUser_metaID($ID);
        if (!$aName) {
            $this->upload();
        }

        $fileUpload = $_FILES['file-upload'];
        /**
         * //Nếu tên file upload khác rỗng
         */
        if ($fileUpload['name'] != null) {
            $filename = $fileUpload['tmp_name'];//Đường dẫn tạm file upload
            $destination = $fileUpload['destination'] = MVC_ASSETS_DIR . 'Images' . '/' . $fileUpload['name'];//Đường dẫn chứa file upload- asset
            move_uploaded_file($filename, $destination);
        } elseif ($fileUpload['name'] == null) {
            $fileUpload['name'] = $aName['meta_value'];
        }
        $aUserInfo = UserModel::getUserByID($ID);
        var_dump($aUserInfo);
        $aData = array_merge($_POST, $fileUpload);
        var_dump($_POST);
        $status = Validator::validate(
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
            Session::add('edit-profile_error', $status);
            Redirect::to('user/edit-profile');
        }

        $aStatus = UserModel::updateUser_meta($aData['fullname'], $aData['name'], $ID);
        $aStatus2 = UserModel::updateUser($aData['username'], $aData['email'], $aData['password'], $ID);

        Session::forget('login_error');
        Redirect::to('user/profile');
    }

    /**
     *
     */
    public function upload()
    {
        $fileUpload = $_FILES['file-upload'];
        /**
         * //Nếu tên file upload khác rỗngs
         */
        if ($fileUpload['name'] != null) {
            $filename = $fileUpload['tmp_name'];//Đường dẫn tạm file upload
            $destination = $fileUpload['destination'] = MVC_ASSETS_DIR . 'Images' . '/' . $fileUpload['name'];
            move_uploaded_file($filename, $destination);
        }
        $aData = array_merge($_POST, $fileUpload);

        $status = Validator::validate(
            array(
                'fullname' => 'required|maxLength:50',
                'name' => 'required|maxLength:50',
                'type' => 'required|checkType',
                'destination' => 'required|maxLength:100'
            ),
            $aData
        );

        if ($status !== true) {
            Session::add('edit-profile_error', $status);
            Redirect::to('user/edit-profile');
        }

        $ID = Session::get(self::$loginSessionKey);
        $astatusUser = UserModel::insertUserMeta($aData['fullname'], $aData['name'], $ID);
        if (!$astatusUser) {
            Session::add('edit-profile_error', 'Oops! Something went error');
            Redirect::to('user/edit-profile');
        }
        Redirect::to('user/profile');
    }

}

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
     * Save Session
     * @var string
     */
    public static $loginSessionKey = "user_logged_in";
  
     * Default method, url:/mvc/user/
     */
    public function index()
    {
        //If not logined
        self::redirectToUserLogin();
        //If logined
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
     * Solving handleRegister when submit
     * Run into ClassLoader.php , required file Validator , solving method validate
     * Check and display error
     */
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
        $aStatus = UserModel::checkUserLogin($_POST["username"], $_POST["password"]);
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
         * if the name of  file upload not null
         */
        if ($fileUpload['name'] != null) {
            $filename = $fileUpload['tmp_name'];
            $destination = $fileUpload['destination'] = MVC_ASSETS_DIR . 'Images' . '/' . $fileUpload['name'];
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
         * if the name of file-upload not null
         */
        if ($fileUpload['name'] != null) {
            $filename = $fileUpload['tmp_name'];
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

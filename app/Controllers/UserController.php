<?php

namespace MVC\Controllers;

use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;
use function PHPSTORM_META\type;

/**
 * Class UserController
 *
 * @package MVC\Controllers
 */
class UserController extends Controller
{
    /**
     * @var string $loginSessionKey
     */
    protected static $loginSessionKey = 'user_logged_in';

    /**
     * @throws \Exception
     */
    public function login()
    {
        $this->redirectToDashboard();//Nếu đã login thì chuyển đến trang dashboard
        $this->loadView('user/login');
    }

    /**
     * @throws \Exception
     * Phương thức register-Hiển thị giao diện
     */
    public function register()
    {
        $this->redirectToDashboard();////Nếu đã login thì chuyển đến trang dashboard
        $this->loadView('user/register');
    }

    //Nếu đã login thì chuyển đến trang dashboard
    public function redirectToDashboard()
    {
        if (self::isLoggedIn()) {
            Redirect::to('user/dashboard');
        }
    }

    /**
     * @throws \Exception
     *  //Phương thức dashboard()-Sau khi login thành công-Hiển thị giao diện
     */
    public function dashboard()
    {
        //Nếu chưa login thì chuyển đến trang login
        if (!self::isLoggedIn()) {
            Redirect::to('user/login');
        }
        $aUserInfo = UserModel::getUserByUsername($_SESSION[self::$loginSessionKey]);
        // $aUserMetaInfo = UserModel::getUserID($_SESSION[self::$loginSessionKey]);
//        $aUserInfo2 =
        $this->loadView('user/dashboard', $aUserInfo);
        var_dump($aUserInfo);
    }

    /**
     * @return bool
     * kiểm tra login chưa
     */
    public static function isLoggedIn()
    {
        return Session::has(self::$loginSessionKey);
    }

    /**
     *
     */
    public function handleLogout()
    {
        Session::forget(self::$loginSessionKey);
        Redirect::to('user/login');
    }

    /**
     * return array
     * @throws \Exception
     */
    public function profile()
    {
        if (!self::isLoggedIn()) {
            Redirect::to('user/login');
        }
        $aUserInfo = UserModel::getUserByUsername($_SESSION[self::$loginSessionKey]);
//        var_dump($aUserInfo);
        $username = Session::get(self::$loginSessionKey);
        $userID = UserModel::getUserID($username);
        $aName = UserModel::getUser_metaID($userID);
//        var_dump($aName);

        if (!$aName) {
            $aName = array();
            $this->loadView('user/profile', $aUserInfo);
        }
        $aData = array_merge($aUserInfo, $aName);
        $this->loadView('user/profile', $aData);
//        var_dump($aUserInfo);
    }

    /**
     * @throws \Exception
     * Kiểm tra URL editProfile , chưa đăng nhập thì không vào được edit-profile
     */
    public function editProfile()
    {
        if (!self::isLoggedIn()) {
            Redirect::to('user/login');
        }

        $username = Session::get(self::$loginSessionKey);
        $userID = UserModel::getUserID($username);
        $aName = UserModel::getUser_metaID($userID);
        $aUserInfo = UserModel::getUserByUsername($_SESSION[self::$loginSessionKey]);
        if (!$aName) {
            $aName = array();
            $this->loadView('user/edit-profile', $aUserInfo);
//            var_dump($aUserInfo);
        }
        else {
            $aData = array_merge($aUserInfo, $aName);
            $this->loadView('user/edit-profile', $aData);
        }

        $aData = array_merge($aUserInfo, $aName);

        $status = Validator::validate(
            array(
                'fullname' => 'required|maxLength:50',
                'name' => 'required|maxLength:50',
                'type' => 'required|checkType',
                'destination' => 'required|maxLength:100',
                'username' => 'required|maxLength:50',
                'password' => 'required|maxLength:20',
                'email' => 'required|maxLength:50'
            ),
            $aData
        );
        if ($status !== true) {
            Session::add('') ;
        }
    }

    /**
     * //Xủ lý khi nhấn submit
     */
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
        //Kiểm tra Email có tồn tại hay không
        //Include file UserModel extend DB Factory--> include DB Factory
        //Nhảy đến phương thức UserModel::emailExists
        if (UserModel::emailExists($_POST['email'])) {
            Session::add('register_error', 'Oops! This email is already exist');
            Redirect::to('user/register');
        }
        //Kiểm tra Username có tồn tại hay không
        //Nhảy đến phương thức UserModel::usernameExists
        if (UserModel::usernameExists($_POST['username'])) {
            Session::add('register_error', 'Oops! This username is already exist');
            Redirect::to('user/register');
        }

        ////Nhảy đến phương thức UserModel::insertNewUser
        $status = UserModel::insertNewUser($_POST['username'], $_POST['email'], $_POST['password']);
        if (!$status) {
            Session::add('register_error', 'Oops! Something went error');
            Redirect::to('user/register');
        }

        Session::add(self::$loginSessionKey, $_POST['username']);//include file app/Support/Session.php, lưu username biến $Session
        Session::forget('register_error');
        Redirect::to('user/dashboard');//Include file app/Support/redirect
    }

    /**
     * Xử lý khi nhấn loggin
     */
    public function handleLogin()
    {
//        var_dump($aStatus[]);
        $status = Validator::validate(
            array(
                'username' => 'required|maxLength:50',
                //'email' => 'required|maxLength:100',
                'password' => 'required'
            ),
            $_POST
        );

        if ($status !== true) {
            Session::add('register_error', $status);
            Redirect::to('user/register');
        }
        $aStatus = UserModel::checkUser($_POST['username'], $_POST['password']);
        if ($aStatus != true) {
            Session::add('login_error', 'invalid username or password');
            Redirect::to('user/login');
        }
        Session::add(self::$loginSessionKey, $_POST['username']);//include file app/Support/Session.php, lưu username biến $Session
        Session::forget('login_error');
        Redirect::to('user/dashboard');
    }

    /**
     *  Upload anh lên server , lưu ảnh vào đường dẫn
     */

    public function upload()
    {

        $fileUpload = $_FILES['file-upload'];
//        var_dump($fileUpload);
        /**
         * //Nếu tên file upload khác rỗngs
         */
        if ($fileUpload['name'] != null) {
            $filename = $fileUpload['tmp_name'];//Đường dẫn tạm file upload
            $destination = $fileUpload['destination'] = MVC_ASSETS_DIR . 'Images' . '/' . $fileUpload['name'];//Đường dẫn chứa file upload- asset
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

        $username = Session::get(self::$loginSessionKey);
        $userID = UserModel::getUserID($username);

        ////Nhảy đến phương thức UserModel::insertNewUser
        $astatusUser = UserModel::insertUserMeta($aData['fullname'], $aData['name'], $userID);

        if (!$astatusUser) {
            Session::add('edit-profile_error', 'Oops! Something went error');
            Redirect::to('user/edit-profile');
        }

//        Session::forget('login_error');
//        Redirect::to('user/profile');
//          var_dump($aData);
    }
}

//        if (UserModel::usernameExists($_POST['fullname'])) {
//            Session::add('dashboard_error', 'Oops! This email is already exist');
//            Redirect::to('user/edit-profile');
//        }
//Nhảy đến phương thức UserModel::usernameExists
//        if (UserModel::checkType($_POST['fileupload'])) {
//            Session::add('dashboard_error', 'Oops! This username is already exist');
//            Redirect::to('user/edit-profile');
//        }
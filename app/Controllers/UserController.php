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
     *                   //Phương thức register-Hiển thị giao diện
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
     * @throws \Exception
     *                   //Kiểm tra URL editProfile , chưa đăng nhập thì không vào được edit-profile
     */
    public function editProfile()
    {
        $this->loadView('user/edit-profile');
        if (!self::isLoggedIn()) {
            Redirect::to('user/login');
        }
        $aUserInfo=UserModel::getUserByUsername($_SESSION[self::$loginSessionKey]);
        var_dump($aUserInfo);
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
        //Kiểm tra emial có tồn tại hay không
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
     *
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
        /**
         * //Nếu tên file upload khác rỗngs
         */
        if ($fileUpload['name'] != null) {
            $filename = $fileUpload['tmp_name'];//Đường dẫn tạm file upload
            $destination = MVC_ASSETS_DIR . 'Images' . '/' . $fileUpload['name'];//Đường dẫn chứa file upload- asset
            move_uploaded_file($filename, $destination);
        }
        $aData = array_merge($_POST, $fileUpload);
        $status = Validator::validate(
            array(
                'fullname' => 'required|maxLength:50',
                'type' => 'required|checkType'
            ),
            $aData
        );

        if ($status !== true) {
            Session::add('edit-profile_error', $status);
            Redirect::to('user/edit-profile');
        }

        $username = Session::get(self::$loginSessionKey);
        $userID = UserModel::getUserID($username);
        var_dump($userID);
        ////Nhảy đến phương thức UserModel::insertNewUser
        $astatusUser = UserModel::insertUserMeta( $aData['fullname'], $aData['type'],$userID);
        if (!$astatusUser) {
            Session::add('edit-profile_error', 'Oops! Something went error');
            Redirect::to('user/edit-profile');
        }
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
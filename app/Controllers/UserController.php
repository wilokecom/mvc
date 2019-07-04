<?php declare(strict_types=1);
namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\UserModel;
use MVC\Support\Pagination;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;
use MVC\Support\Route;

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
    public static $sLoginSessionKey = "user_logged_in";
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
     * If not logined, returned to user/login
     */
    public static function redirectToUserLogin()
    {
        if (!self::isLoggedIn()) {
            Redirect::to("user/login");
        }
    }
    /**
     * Check logined or not
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Session::has(self::$sLoginSessionKey);
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
     * Method register-Show Interface
     * @throws \Exception
     */
    public function register()
    {
        self::redirectToDashboard();
        $this->loadView("user/register");
    }
    /**
     * @throws \Exception
     */
    public function dashboard()
    {
        self::redirectToUserLogin();
        $abUserInfo = UserModel::getUserByUsername(
            $_SESSION[self::$sLoginSessionKey]
        );
        $iPostAuthor=$abUserInfo["ID"];
        $iTotalRecords = PostModel::getRecordbyPostAuthor($iPostAuthor);
        $aConfig       = array(
            'current_page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'total_record' => $iTotalRecords,
            'limit' => 3,
            'link_full' => Route::get('user/dashboard?page={page}'),
            'link_first' => Route::get('user/dashboard'),
            'range' => 5
        );
        //Init pagination
        Pagination::init($aConfig);
        $iPostStart = Pagination::$aConfig["start"];
        $iPostLimit = Pagination::$aConfig["limit"];
        $abPostInfo = PostModel::getPostbyPostAuthor(
            $abUserInfo["ID"],
            $iPostStart,
            $iPostLimit
        );
        //If $aPosts=false, return empty array
        if (!$abPostInfo) {
            $abPostInfo = array();
        }
        //Handle Ajax
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            die(
                json_encode(
                    array("abUserInfo" => $abUserInfo, "abPostInfo" => $abPostInfo, "paging" => Pagination::display())
                )
            );
        }
        $this->loadView(
            "user/dashboard",
            $abUserInfo,
            $abPostInfo
        );
    }
    /**
     * Handle when press logout$iTotalPage
     * Destroy Session Login
     * Return to user/login
     */
    public function handleLogout()
    {
        Session::forget(self::$sLoginSessionKey);
        Redirect::to("user/login");
    }
    /**
     * Handle Register, when press submit
     */
    public function handleRegister()
    {
        $bStatus = Validator::validate(
            array(
                "username" => "required|maxLength:50",
                "email" => "required|maxLength:100",
                "password" => "required",
                "agree_term" => "required"
            ),
            $_POST
        );
        //If has error, add error to Session, return to user/register
        if ($bStatus !== true) {
            Session::add("register_error", $bStatus);
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
        Session::add(
            self::$sLoginSessionKey,
            $_POST["username"]
        );
        Session::forget("register_error");//delete Session
        Redirect::to("user/dashboard");
    }
    /**
     * handleLogin-After login
     */
    public function handleLogin()
    {
        //Validate
        $bStatus = Validator::validate(
            array(
                "username" => "required|maxLength:50",
                "password" => "required"
            ),
            $_POST
        );
        if ($bStatus !== true) {
            Session::add("login_error", $bStatus);
            Redirect::to("user/login");
        }
        $abStatus = UserModel::checkUserLogin($_POST["username"], $_POST["password"]);
        if ($abStatus != true) {
            Session::add("login_error", "invalid username or password");
            Redirect::to("user/login");
        }
        //Add Session[$sLoginSessionKey]=$_POST["username"]
        Session::add(
            self::$sLoginSessionKey,
            $_POST["username"]
        );
        //Destroy error
        Session::forget("login_error");
        Redirect::to("user/dashboard");
    }
}


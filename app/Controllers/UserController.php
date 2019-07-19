<?php declare(strict_types=1);
namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\TermsModel;
use MVC\Models\UserModel;
use MVC\Models\TaxonomyModel;
use MVC\Support\Pagination;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;
use MVC\Support\Route;
use MVC\Support\Auth;

/**
 * Class UserController
 *
 * @package MVC\Controllers
 */
class UserController extends Controller
{
    /**
     * Check if not loggined, go to user/login
     * Default method, url:/mvc/user/
     */
    public function index()
    {
        $this->middleware(["auth"]);
    }
    /**
     * Check logined or not
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Session::has(Auth::$sLoginSessionKey);
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
    /*
     * Phương thức register-Show Interface
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
        $this->middleware(["auth"]);
        $abUserInfo    = UserModel::getUserByUsername(
            $_SESSION[Auth::$sLoginSessionKey]
        );
        $iPostAuthor   = $abUserInfo["ID"];
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
        //Get category and tag for display posts table
        $aPostID = PostModel::getPostIDbyPostAuthor($iPostAuthor);
        $aCategoryName=array();
        $aTagName=array();
        if ($aPostID != false) {
            for ($i = 0; $i < count($aPostID); $i++) {
                $aTermTaxonomyID[$i] = TaxonomyModel::getTaxonomyID($aPostID[$i]["ID"]);
                if ($aTermTaxonomyID[$i] == false) {
                    unset($aTermTaxonomyID[$i]);
                } else {
                    for ($j = 0; $j < count($aTermTaxonomyID[$i]); $j++) {
                        //Get category
                        $aCategoryID[$i][$j] = TaxonomyModel::getTermID(
                            $aTermTaxonomyID[$i][$j]["term_taxonomy_id"],
                            "category"
                        );
                        if ($aCategoryID[$i][$j] != false) {
                            for ($k = 0; $k < count($aCategoryID[$i]); $k++) {
                                $aCategoryName[$i][$k] = TermsModel::getTermNameByTermID(
                                    $aCategoryID[$i][$k]["term_id"]
                                );
                            }
                        }
                        //Get Tag
                        $aTagID[$i][$j] = TaxonomyModel::getTermID(
                            $aTermTaxonomyID[$i][$j]["term_taxonomy_id"],
                            "tag"
                        );
                        if ($aTagID[$i][$j] != false) {
                            for ($k = 0; $k < count($aTagID[$i]); $k++) {
                                $aTagName[$i][$k] = TermsModel::getTermNameByTermID($aTagID[$i][$k]["term_id"]);
                            }
                        }
                    }
                }
            }
        }
        foreach ($abPostInfo as $key => $value) {
            $abPostInfo[$key]["category"] = "";
            $abPostInfo[$key]["tag"]      = "";
        }
        //Category
        foreach ($aCategoryName as $key => $value) {
            //Make $value into string
            for ($i = 0; $i < count($value); $i++) {
                if ($value[$i]) {
                    $aCategoryList[$i] = $value[$i]["term_name"];
                }
            }
            $sCategoryList = implode(",", $aCategoryList);
            //Get ID of aPostID
            if (array_key_exists($key, $aPostID)) {
                $iID = $aPostID[$key]["ID"];
            }
            //Insert element category into abPost
            for ($i = 0; $i < count($abPostInfo); $i++) {
                if ($abPostInfo[$i]["ID"] == $iID) {
                    $abPostInfo[$i]["category"] = $sCategoryList;
                }
            }
        }
        //Tag
        foreach ($aTagName as $key => $value) {
            $aTagList = array();
            //Make $value into string
            for ($i = 0; $i < count($value); $i++) {
                if ($value[$i]) {
                    $aTagList[$i] = $value[$i]["term_name"];
                }
            }
            $sTagList = implode(",", $aTagList);
            //Get ID of abPostID
            if (array_key_exists($key, $aPostID)) {
                $iID = $aPostID[$key]["ID"];
            }
            //Insert element tag into array abPost
            for ($i = 0; $i < count($abPostInfo); $i++) {
                if ($abPostInfo[$i]["ID"] == $iID) {
                    $abPostInfo[$i]["tag"] = $sTagList;
                }
            }
        }
        //Handle Ajax
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            die(
                json_encode(
                    array(
                        "abUserInfo" => $abUserInfo,
                        "abPostInfo" => $abPostInfo,
                        "paging" => Pagination::display()
                    )
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
        Session::forget(Auth::$sLoginSessionKey);
        Redirect::to("user/login");
    }

    /**
     * Solving handleRegister when submit
     * Run into ClassLoader.php , required file Validator , solving method validate
     * Check and display error
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
        //Check email exist
        if (UserModel::emailExists($_POST["email"])) {
            Session::add("register_error", "Oops! This email is already exist");
            Redirect::to("user/register");
        }
        //Check username exist
        if (UserModel::usernameExists($_POST["username"])) {
            Session::add("register_error", "Oops! This username is already exist");
            Redirect::to("user/register");
        }
        $aStatus = UserModel::insertNewUser($_POST["username"], $_POST["email"], $_POST["password"]);
        if (!$aStatus) {
            Session::add("register_error", "Oops! Something went error");
            Redirect::to("user/register");
        }
        //Save username to Session["user_logged_in"]
        Session::add(
            Auth::$sLoginSessionKey,
            $_POST["username"]
        );
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
            Auth::$sLoginSessionKey,
            $_POST["username"]
        );
        //Destroy error
        Session::forget("login_error");
        Redirect::to("user/dashboard");
    }

    /**
     * @throws \Exception
     */
    public function profile()
    {
        if (!self::isLoggedIn()) {
            Redirect::to('user/login');
        }
        $ID        = Session::get(Auth::$loginSessionKey);
        $aUserInfo = UserModel::getUserByID($ID);
        $aName     = UserModel::getUser_metaID($ID);

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
        $aName     = UserModel::getUser_metaID(Session::get(Auth::$loginSessionKey));
        $aUserInfo = UserModel::getUserByID(Session::get(Auth::$loginSessionKey));
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
        $ID    = Session::get(Auth::$loginSessionKey);
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
        $ID          = Session::get(Auth::$loginSessionKey);
        $astatusUser = UserModel::insertUserMeta($aData['fullname'], $aData['name'], $ID);
        if (!$astatusUser) {
            Session::add('edit-profile_error', 'Oops! Something went error');
            Redirect::to('user/edit-profile');
        }
        Redirect::to('user/profile');
    }
}


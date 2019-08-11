<?php
namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;
use MVC\Support\Upload;
use MVC\Support\Route;
use MVC\Support\Pagination;

/**
 * Class CategoryController
 * @package MVC\Controllers
 */
class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function index()
    {
        Redirect::to('category/dashboard');
    }
    public function dashboard()
    {
        //        $iID = Session::get(UserController::$loginSessionKey);
        //        $aTermInfo =
        $aData = array();
        $this->loadView(
            'category/dashboard',
            false
        );
    }
    public function add()
    {
        UserController::redirectToUserLogin();
        $this->loadView('category/add');
    }
}

<?php
namespace MVC\Controller;


use MVC\Models\PostModel;
use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;

/**
 * Class UserController
 *
 * @package MVC\Controller
 */
class UserController extends  Controller
{
    /**
     *git status
     */
    public function index()
    {
        Redirect::to('post/add');
    }

    /**
     * Nếu chưa đăng nhập chuyển về trang login
     */
    public function add()
    {

        UserController::redirectToUserLogin();
        $this->loadView("post/add");
    }
}
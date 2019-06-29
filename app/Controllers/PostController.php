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
     * Default method, link url:mvc/post/
     * Go to method add
     */
    public function index()
    {
        Redirect::to("post/add");
    }

     * If not logined, return user/login
     * @throws \Exception
     */
    public function add()
    {
        UserController::redirectToUserLogin();
        $this->loadView("post/add");
    }
    /**
     * If not logined, return user/login
     * @param $aParam
     * @throws \Exception
     */
    public function edit($aParam)
    {
        UserController::redirectToUserLogin();
        //Get PostID
        $post_id = $aParam[2];
        unset($aParam[2]);//delete $aParam[2]
        //Get PostInfo
        $aPostInfo = PostModel::getPostbyPostID($post_id);
        //If $aPostInfo is false, return empty array
        if (!$aPostInfo) {
            $aPostInfo = array();
        }
        $this->loadView("post/edit", $aPostInfo, $post_id);
    }
    /**
     * Delete info post table
     */
    public function delete()
    {
        //Get post_id
        $post_id = $_POST["post_id"];
        //Get data post table
        $aPostInfo = PostModel::deletePostbyPostID($post_id);
        if ($aPostInfo) {
            echo "Delete Success";
        } else {
            echo "Delete Error";
        }
    }
    /**
     * Method handleAdd()
     */
    public function handleAdd()
    {
        $imageUpload = $_FILES["image-upload"];
        $aData       = array_merge(//merge array to validate
            $_POST,
            $imageUpload
        );
        $status = Validator::validate(
            array(
                "post-title" => "required|maxLength:100",
                "post-content" => "required|maxLength:10000",
                "name" => "required|maxLength:20",
                "type" => "checkType",
                "size" => "maxSize:500000"
            ),
            $aData
        );
        //If has error, add error to Session, return post/add
        if ($status !== true) {
            Session::add("post_error", $status);
            Redirect::to("post/add");
        }
        //Get username login
        $username = Session::get(UserController::$loginSessionKey);
        //Get userID
        $userID = UserModel::getUserByUsername($username)["ID"];
        //Get guid
        $guid = MVC_HOME_URL . "post/add/" . $aData["post-type"] . "_id="
                . $userID;
        //Insert to Post table
        $aStatusPost = PostModel::insertPost(
            $userID,
            $aData["post-status"],
            $aData["post-type"],
            $aData["post-title"],
            $aData["post-content"],
            $aData["type"],
            $guid
        );
        if (!$aStatusPost) {
            Session::add(
                "post_error",
                "Oops! Something went Post_Add error"
            );
            Redirect::to("post/add");
        }
        // Insert to PostMeta table
        $aStatusMeta = PostModel::insertPostMeta(
            "phone number",
            $aData["phone-number"],
            $aStatusPost
        );
        if (!$aStatusMeta) {
            Session::add("post_error", "Oops! Something went Post_Meta error");
            Redirect::to("post/add");
        }
        $imagename = $imageUpload["tmp_name"];//Đường dẫn tạm file upload
        //Link contains file upload(assets/image)
        $destination = MVC_ASSETS_DIR . "image" . "/" . $imageUpload["name"];
        move_uploaded_file($imagename, $destination);
        //Destroy Error
        Session::forget("post_error");
        //Go todashboard
        Redirect::to("user/dashboard");
    }
    /**
     * @param $aParam
     */
    public function handleEdit($aParam)
    {
        //Get PostID
        $id = $aParam[2];
        //Validate $_POST
        $status = Validator::validate(
            array(
                "post-title" => "required|maxLength:100",
                "post-content" => "required|maxLength:10000",
            ),
            $_POST
        );
        //If has error, add error to Session, return  post/edit/id/
        if ($status !== true) {
            Session::add("post_error", $status);
            Redirect::to("post/edit/" . $id . "/");
        }
        //Update Post by PostID
        $aStatusPost = PostModel::updatePostbyPostID(
            $_POST["post-status"],
            $_POST["post-type"],
            $_POST["post-title"],
            $_POST["post-content"],
            $id
        );
        if (!$aStatusPost) {
            Session::add(
                "post_error",
                "Oops! Something went Post_Edit error"
            );
            Redirect::to("post/edit/" . $id . "/");
        }
        Session::forget("post_error");
        //Go to dashboard
        Redirect::to("user/dashboard");
    }
}
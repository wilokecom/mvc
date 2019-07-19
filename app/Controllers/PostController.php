<?php
namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;
use MVC\Support\Upload;

/**
 * Class PostController
 * @package MVC\Controllers
 */
class PostController extends Controller
{
    /**
     * Default method, link url:mvc/post/
     * Go to method add
     */
    public function index()
    {
        Redirect::to("post/add");
    }
    /**
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
        $postID = $aParam[2];
        unset($aParam[2]);//delete $aParam[2]
        //Get PostInfo
        $aPostInfo = PostModel::getPostbyPostID($postID);
        //If $aPostInfo is false, return empty array
        if (!$aPostInfo) {
            $aPostInfo = array();
        }
        $this->loadView(
            "post/edit",
            $aPostInfo,
            $postID
        );
    }
    /**
     * Delete Post by Getting ID
     * Notice : The Foreinkey can make program error , can't delete data in
     * MySql because of having to delete all data in 2 or 3 table . So that ,
     * when creating table and Forein key , should add CASCADE ON DELETE
     */
    public function delete()
    {
        $iID = isset($_POST["post_id"]) ? $_POST["post_id"] : null;
        $iID = (int)$iID;
        $aPostInfo = PostModel::deletePost($iID);
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
        $aImageUpload = Upload::upload('image-upload');
        $aData        = array_merge(
            $_POST,
            $aImageUpload
        );
        var_dump($aData);
        $bStatus = Validator::validate(
            array(
                "post-title" => "required|maxLength:100",
                "post-content" => "required|maxLength:10000",
                "name" => "required|maxLength:200",
                "type" => "checkType",
                "size" => "maxSize:5000000"
            ),
            $aData
        );
        //If has error, add error to Session, return post/add
        if ($bStatus !== true) {
            Session::add(
                "post_error",
                $bStatus
            );
            Redirect::to("post/add");
        }
        $userID      = Session::get(UserController::$loginSessionKey);
        $sGuid       = MVC_HOME_URL . "post/add/" . $aData["post-type"] . "_id="
                       . $userID;
        $aStatusPost = PostModel::insertPost(
            $userID,
            $aData['post-status'],
            $aData['post-type'],
            $aData['post-title'],
            $aData['post-content'],
            $aData['type'],
            $sGuid
        );
        if (!$aStatusPost) {
            Session::add(
                "post_error",
                "Oops! Something went Post_Add error" 
            );
            Redirect::to("post/add");
        }
        $aStatusMeta = PostModel::insertPostMeta(
            "phone number",
            $aData["phone-number"],
            $aStatusPost
        );
        if (!$aStatusMeta) {
            Session::add(
                "post_error",
                "Oops! Something went Post_Meta error"
            );
            Redirect::to("post/add");
        }
        Session::forget("post_error");
        Redirect::to("user/dashboard");
    }
    /**
     * @param $aParam
     */
    public function handleEdit($aParam)
    {
        $id = $aParam[2];
        $status = Validator::validate(
            array(
                "post-tittle" => "required|maxLength:100",
                "post-content" => "required|maxLength:10000",
            ),
            $_POST
        );
        if ($status !== true) {
            Session::add(
                "post_error",
                $status
            );
            Redirect::to("post/edit/" . $id . "/");
        }
        $aStatusPost = PostModel::updatePostbyPostID(
            $_POST["post-status"],
            $_POST["post-type"],
            $_POST["post-tittle"],
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
        Redirect::to("user/dashboard");
    }
}

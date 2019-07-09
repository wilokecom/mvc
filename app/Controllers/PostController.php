<?php 
declare(strict_types=1);
namespace MVC\Controllers;

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
     * @throws \Exception
     */
    public function edit()
    {
        UserController::redirectToUserLogin();
        //Get PostID
        $iPostID = isset($_GET["post-id"]) ? $_GET["post-id"] : null;
        //Get PostInfo
        $aPostInfo = PostModel::getPostbyPostID($iPostID);
        //If $aPostInfo is false, return empty array
        if (!$aPostInfo) {
            $aPostInfo = array();
        }
        $this->loadView("post/edit", $aPostInfo);
    }
    /**
     * Delete info post table
     */
    public function delete()
    {
        //Get PostID
        $iPostID = isset($_POST["post_id"]) ? $_POST["post_id"] : null;
        //Get data post table
        $aPostInfo = PostModel::deletePostbyPostID($iPostID);
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
        $aImageUpload = $_FILES["image-upload"];
        $aData        = array_merge(//merge array to validate
            $_POST,
            $aImageUpload
        );
        $bStatus      = Validator::validate(
            array(
                "post-title" => "required|maxLength:100",
                "post-content" => "required|maxLength:10000",
                "name" => "required|maxLength:20",
                "type" => "checkImageType",
                "size" => "maxSize:500000"
            ),
            $aData
        );
        //If has error, add error to Session, return post/add
        if ($bStatus !== true) {
            Session::add("post_error", $bStatus);
            Redirect::to("post/add");
        }
        //Get username login
        $sUserName = Session::get(UserController::$sLoginSessionKey);
        //Get userID
        $iUserID = UserModel::getUserByUsername($sUserName)["ID"];
        //Get guid
        $sGuid = MVC_HOME_URL . "post/add/" . $aData["post-type"] . "_id=" . $iUserID;
        //Insert to Post table
        $aStatusPost = PostModel::insertPost(
            $iUserID,
            $aData["post-status"],
            $aData["post-type"],
            $aData["post-title"],
            $aData["post-content"],
            $aData["type"],
            $sGuid
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
            Session::add(
                "post_error",
                "Oops! Something went Post_Meta error"
            );
            Redirect::to("post/add");
        }
        $sImageName = $aImageUpload["tmp_name"];//Temporary file upload file
        //Link contains file upload(assets/image)
        $sDestination = MVC_ASSETS_DIR . "image" . "/" . $aImageUpload["name"];
        move_uploaded_file(
            $sImageName,
            $sDestination
        );
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
        $iPostID = isset($_GET["post-id"]) ? $_GET["post-id"] : null;
        //Validate $_POST
        $bStatus = Validator::validate(
            array(
                "post-title" => "required|maxLength:100",
                "post-content" => "required|maxLength:10000",
            ),
            $_POST
        );
        //If has error, add error to Session, return  post/edit/id/
        if ($bStatus !== true) {
            Session::add(
                "post_error",
                $bStatus
            );
            Redirect::to("post/edit?post-id=" . $iPostID);
        }
        //Update Post by PostID
        $aStatusPost = PostModel::updatePostbyPostID(
            $_POST["post-status"],
            $_POST["post-type"],
            $_POST["post-title"],
            $_POST["post-content"],
            $iPostID
        );
        if (!$aStatusPost) {
            Session::add(
                "post_error",
                "Oops! Something went Post_Edit error"
            );
            Redirect::to("post/edit?post-id=" . $iPostID . "/");
        }
        Session::forget("post_error");
        //Go to dashboard
        Redirect::to("user/dashboard");
    }

}

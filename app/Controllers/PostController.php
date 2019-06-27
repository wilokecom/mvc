<?php
namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;

/**
 * Class PostController
 * @package MVC\Controllers
 */
class PostController extends Controller
{
    /**
     * Phương thức mặc định, đường dẫn url:mvc/post/
     */
    public function index()//Phương thức mặc định, đường dẫn url:mvc/post/
    {
        //Nhảy đến phương thức add
        Redirect::to("post/add");
    }
    /**
     * @throws \Exception
     */
    public function add()
    {
        //Nếu chưa đăng nhập chuyển về trang login
        UserController::redirectToUserLogin();
        $this->loadView("post/add");
    }
    /**
     * @param $aParam
     * @throws \Exception
     */
    public function edit($aParam)
    {
        //Nếu chưa đăng nhập chuyển về trang login
        UserController::redirectToUserLogin();
        //Lấy PostID
        $post_id = $aParam[2];
        unset($aParam[2]);//Xóa Param
        //Lấy thông tin bảng Post theo PostID
        $aPostInfo = PostModel::getPostbyPostID($post_id);
        if (!$aPostInfo) { //Nếu $aPosts=false thì trả về mảng rỗng
            $aPostInfo = array();
        }
        //$aPostInfo=$aPostInfo[$id];
        //$aData = array_merge($aUserInfo, $aPostInfo);
        $this->loadView("post/edit", $aPostInfo, $post_id);
    }
    /**
     * Xóa thông tin bảng post
     */
    public function delete()
    {
        //Lấy post_id
        $post_id = $_POST["post_id"];
        //Xóa dữ liệu bảng Post
        $aPostInfo = PostModel::deletePostbyPostID($post_id);
        if ($aPostInfo) {
            echo "Delete Success";
        } else {
            echo "Delete Error";
        }
    }
    /**
     * Phương thức handleAdd()
     */
    public function handleAdd()
    {
        $imageUpload = $_FILES["image-upload"];
        $aData       = array_merge(
            $_POST, $imageUpload
        );//Gộp 2 mảng để Validate
        //Validate cả $_POST và $_FILE
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
        //Nếu có lỗi, khởi tạo và add Session, chuyển về đường dẫn post/add
        if ($status !== true) {
            Session::add("post_error", $status);
            Redirect::to("post/add");
        }
        //Lấy username login
        $username = Session::get(UserController::$loginSessionKey);
        //Lấy userID
        $userID = UserModel::getUserByUsername($username)["ID"];
        //Lấy guid
        $guid = MVC_HOME_URL . "post/add/" . $aData["post-type"] . "_id="
                . $userID;
        //Insert vào bảng Posts
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
        // Insert vào bảng PostMeta
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
        //Đường dẫn chứa file upload(assets/image)
        $destination = MVC_ASSETS_DIR . "image" . "/" . $imageUpload["name"];
        move_uploaded_file($imagename, $destination);
        //Destroy Error
        Session::forget("post_error");
        //Quay trở lịa trang dashboard
        Redirect::to("user/dashboard");
    }
    /**
     * @param $aParam
     */
    public function handleEdit($aParam)
    {
        //Lấy PostID
        $id = $aParam[2];
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        //Validate $_POST
        $status = Validator::validate(
            array(
                "post-title" => "required|maxLength:100",
                "post-content" => "required|maxLength:10000",
            ),
            $_POST
        );
        //Nếu có lỗi, khởi tạo và add Session, chuyển về đường dẫn post/edit/id/
        if ($status !== true) {
            Session::add("post_error", $status);
            Redirect::to("post/edit/" . $id . "/");
        }
        //Update bảng Post theo PostID
        $aStatusPost = PostModel::updatePostbyPostID(
            $_POST["post-status"], $_POST["post-type"], $_POST["post-title"],
            $_POST["post-content"], $id
        );
        if (!$aStatusPost) {
            Session::add(
                "post_error",
                "Oops! Something went Post_Edit error"
            );
            Redirect::to("post/edit/" . $id . "/");
        }
        Session::forget("post_error");
        //Quay trở lại trang dashboard
        Redirect::to("user/dashboard");
    }
}


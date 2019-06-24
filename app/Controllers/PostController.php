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
     * @var string
     */
    protected static $loginSessionKey = "user_logged_in";//Lưu Sesion Login
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
        $this->loadView("post/add");
    }
    /**
     * @throws \Exception
     */
    public function edit()
    {
        $this->loadView("post/edit");
    }
    /**
     * Phương thức handleAdd()
     */
    public function handleAdd()
    {
        echo "<pre>";
        print_r($_POST);
        print_r($_FILES["image-upload"]);
        echo "</pre>";
        $imageUpload = $_FILES["image-upload"];
        $aData       = array_merge(
            $_POST,
            $imageUpload
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
        $username = Session::get(self::$loginSessionKey);
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
                "Oops! Something went Post error"
            );
            Redirect::to("post/add");
        }
        //Insert vào bảng PostMeta
        $aStatusMeta = PostModel::insertPostMeta(
            "phone number",
            $aData["phone-number"],
            $aStatusPost
        );
        if (!$aStatusMeta) {
            Session::add("post_error", "Oops! Something went PostMeta error");
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
     *
     */
    public function handleEdit ()
    {
        Redirect::to("user/dashboard");
    }
}


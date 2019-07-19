<?php
declare(strict_types=1);
namespace MVC\Controllers;

use MVC\Models\PostModel;
use MVC\Models\TaxonomyModel;
use MVC\Models\TermsModel;
use MVC\Models\UserModel;
use MVC\Support\Redirect;
use MVC\Support\Session;
use MVC\Support\Validator;
use MVC\Support\Auth;

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
     * @throws \Exception
     */
    public function add()
    {
        $this->middleware(['auth']);
        //Get CategoryName
        $aCategoryName = TermsModel::getTermName("category");
        //Get TagName
        $aTagName = TermsModel::getTermName("tag");
        $this->loadView("post/add", $aCategoryName, $aTagName);
    }
    /**
     * @throws \Exception
     */
    public function edit()
    {
        $this->middleware(['auth']);
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
        $sUserName = Session::get(Auth::$sLoginSessionKey);
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
        //Category
        if(isset($_POST["category"])){
            $aCategoryName=$_POST["category"];
            for($i=0;$i<count($aCategoryName);$i++){
                $aTermCategoryID[$i]=TaxonomyModel::getTermTaxonomyID($aCategoryName[$i],"category");
                //Insert to TermRelationShip Table
                TaxonomyModel::insertTermRelationShip($aStatusPost,$aTermCategoryID[$i]["term_taxonomy_id"]);
                //Update to Term_taxonomy Table
                TaxonomyModel::updateCount($aTermCategoryID[$i]["term_taxonomy_id"]);
            }
        }
        //Tag
        if(isset($_POST["tag"])){
            $aTagName=$_POST["tag"];
            for($i=0;$i<count($aTagName);$i++){
                $aTermTagID[$i]=TaxonomyModel::getTermTaxonomyID($aTagName[$i],"tag");
                TaxonomyModel::insertTermRelationShip($aStatusPost,$aTermTagID[$i]["term_taxonomy_id"]);
                TaxonomyModel::updateCount($aTermTagID[$i]["term_taxonomy_id"]);
            }
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
        Redirect::to("user/dashboard");
    }
    /**
     * Handle Edit:After press change
     */
    public function handleEdit()
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
        Redirect::to("user/dashboard");
    }
}

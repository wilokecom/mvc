<?php declare(strict_types=1);
namespace MVC\Controllers;

use MVC\Models\TaxonomyModel;
use MVC\Models\TermsModel;
use MVC\Support\Pagination;
use MVC\Support\Redirect;
use MVC\Support\Route;
use MVC\Support\Session;
use MVC\Support\Validator;

/**
 * Class TagController
 * @package MVC\Controllers
 */
class TagController extends Controller
{
    /**
     *Index: In the case, user do not write the method of class Tag
     */
    public function index()
    {
        Redirect::to("tag/dashboard");
    }
    /**
     * @throws \Exception
     */
    public function add()
    {
        $this->middleware(['auth']);
        $this->loadView("tag/add");
    }
    /**
     *Display dashboard of Tag
     */
    public function dashboard()
    {
        $this->middleware(["auth"]);
        $iTotalRecords = TaxonomyModel::getRecordByTaxononmy("tag");
        $aConfig       = array(
            'current_page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'total_record' => $iTotalRecords,
            'limit' => 3,
            'link_full' => Route::get('tag/dashboard?page={page}'),
            'link_first' => Route::get('tag/dashboard'),
            'range' => 5
        );
        //Init pagination
        Pagination::init($aConfig);
        $iTermsStart = Pagination::$aConfig["start"];
        $iTermsLimit = Pagination::$aConfig["limit"];
        $abTagInfo   = TermsModel::getTermByTaxonomy(
            "tag",
            $iTermsStart,
            $iTermsLimit
        );
        //If $aPosts=false, return empty array
        if (!$abTagInfo) {
            $abTagInfo = array();
        }
        //Handle Ajax for pagination
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            die(json_encode(array("abTagInfo" => $abTagInfo, "paging" => Pagination::display())));
        }
        $this->loadView(
            "tag/dashboard",
            $abTagInfo
        );
    }
    /**
     * Handle Add:after get data from ajax page post/add
     */
    public function handleQuickAdd()
    {
        //Validate
        $bStatus = Validator::validate(
            array(
                "tag_name" => "required|maxLength:10",
            ),
            $_POST
        );
        if ($bStatus !== true) {
            die($bStatus);
        }
        //Get sTagName from $_POST-ajax
        $sTermName = isset($_POST) ? $_POST["tag_name"] : "";
        //Check Tag
        if (TermsModel::checkTermNameExist("tag", $sTermName)) {
            die("Tag Name existed");
        }
        $sSlug    = explode(" ", $sTermName);
        $sSlug    = array_map(
            function ($item) {
                return mb_strtolower($item, "UTF-8");
            },
            $sSlug
        );
        $sTagSlug = implode($sSlug, "-");
        //Insert to term table
        $iStatusTerms = TermsModel::insertTerm($sTermName, $sTagSlug);
        if (!$iStatusTerms) {
            Session::add(
                "tag_error",
                "Oops! TAG ADD TO TERM ERROR"
            );
            Redirect::to("post/add");
        }
        //Insert to Taxonomy table
        $iStatusTaxonomy = TaxonomyModel::insertTaxonomy($iStatusTerms, "tag");
        if (!$iStatusTaxonomy) {
            Session::add(
                "tag_error",
                "Oops! TAG ADD TO TAXONOMY ERROR"
            );
            Redirect::to("post/add");
        }
        //Destroy Error
        Session::forget("tag_error");
        //Handle Ajax
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            die($sTermName);
        }
    }
    /**
     *Handle Add:After press Add Tag
     */
    public function handleAdd()
    {
        //Validate
        $bStatus = Validator::validate(
            array(
                "tag-name" => "required|maxLength:10",
                "slug" => "maxLength:15",
                "description" => "maxLength:15"
            ),
            $_POST
        );
        if ($bStatus !== true) {
            Session::add("tag_error", $bStatus);
            Redirect::to("tag/add");
        }
        $sTermName = $_POST["tag-name"];
        if ($_POST["slug"]=="") {
            $sSlug         = explode(" ", $sTermName);
            $sSlug         = array_map(
                function ($item) {
                    return mb_strtolower($item, "UTF-8");
                },
                $sSlug
            );
            $sTagSlug = implode($sSlug, "-");
        } else {
            $sTagSlug = $_POST["slug"];
        }
        $sDescription =$_POST["description"];
        //        //Check tag Exist
        if (TermsModel::checkTermNameExist("tag", $sTermName)) {
            Session::add("tag_error", "Oops! TAG IS EXISTED");
            Redirect::to("tag/add");
        }
        //Insert to term table
        $iStatusTerms = TermsModel::insertTerm($sTermName, $sTagSlug);
        if (!$iStatusTerms) {
            Session::add(
                "tag_error",
                "Oops! TAG ADD TO TERM ERROR"
            );
            Redirect::to("tag/add");
        }
        //Insert to Taxonomy table
        $iStatusTaxonomy = TaxonomyModel::insertTaxonomy($iStatusTerms, "tag", $sDescription);
        if (!$iStatusTaxonomy) {
            Session::add(
                "tag_error",
                "Oops! TAG ADD TO TAXONOMY ERROR"
            );
            Redirect::to("tag/add");
        }
        //Destroy Error
        Session::forget("tag_error");
        Redirect::to("tag/dashboard");
    }
    /**
     * @throws \Exception
     */
    public function edit()
    {
        $this->middleware(['auth']);
        //Get TagName
        $sTagName = isset($_GET["tag-name"]) ? $_GET["tag-name"] : null;
        $aTagInfo = TermsModel::getTermByTermName($sTagName, "tag");
        if (!$aTagInfo) {
            $aTagInfo = array();
        }
        $this->loadView("tag/edit", $aTagInfo);
    }
    /**
     *HandleEdit:After press Change
     */
    public function handleEdit()
    {
        $sOldTermName = isset($_GET["tag-name"]) ? $_GET["tag-name"] : null;
        //Validate
        $bStatus = Validator::validate(
            array(
                "tag-name" => "required|maxLength:10",
                "slug" => "maxLength:15",
                "description" => "maxLength:15"
            ),
            $_POST
        );
        if ($bStatus !== true) {
            Session::add("tag_error", $bStatus);
            Redirect::to("tag/edit?tag-name=" . $sOldTermName);
        }
        $sTermName = $_POST["tag-name"];
        if ($_POST["slug"] == "") {
            $sSlug         = explode(" ", $sTermName);
            $sSlug         = array_map(
                function ($item) {
                    return mb_strtolower($item, "UTF-8");
                },
                $sSlug
            );
            $stagSlug = implode($sSlug, "-");
        } else {
            $stagSlug = $_POST["slug"];
        }
        $sDescription = $_POST["description"];
        // Check tag Exist
        if (TermsModel::checkTermNameExist("tag", $sTermName)) {
            Session::add("tag_error", "Oops! This TAG IS EXISTED");
            Redirect::to("tag/edit?tag-name=" . $sOldTermName);
        }
        $iTermID = TermsModel::getTermByTermName($sOldTermName, "tag");
        //Insert to term table
        $iStatusTerms = TermsModel::updateTerm($sTermName, $stagSlug, $sOldTermName);
        if (!$iStatusTerms) {
            Session::add(
                "tag_error",
                "Oops! UPDATE TAG TO TERM ERROR"
            );
            Redirect::to("tag/edit?tag-name=" . $sOldTermName);
        }
        //Insert to Taxonomy table
        $iStatusTaxonomy = TaxonomyModel::updateTaxonomy($sDescription, $iTermID);
        if (!$iStatusTaxonomy) {
            Session::add(
                "tag_error",
                "Oops! UPDATE TAG TO TAXONOMY ERROR"
            );
            Redirect::to("tag/edit?tag-name=" . $sOldTermName);
        }
        //Destroy Error
        Session::forget("tag_error");
        Redirect::to("tag/dashboard");
    }
    /**
     * Delete info tag
     */
    public function delete()
    {
        //Get $sTermName
        $iTermID = isset($_POST["term_id"]) ? $_POST["term_id"] : null;
        //Delete term table
        $aTermInfo = TermsModel::deleteTerm($iTermID);
        if ($aTermInfo) {
            echo "Delete Success";
        } else {
            echo "Delete Error";
        }
    }
}

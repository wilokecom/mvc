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
 * Class CategoryController
 * @package MVC\Controllers
 */
class CategoryController extends Controller
{
    /**
     *Index: In the case, user do not write the method of class Category
     */
    public function index()
    {
        Redirect::to("category/dashboard");
    }
    public function add()
    {
        $this->middleware(['auth']);
        $this->loadView("category/add");
    }
    /**
     *Display dashboard of category
     */
    public function dashboard()
    {
        $this->middleware(["auth"]);
        $iTotalRecords = TaxonomyModel::getRecordByTaxononmy("category");
        $aConfig       = array(
            'current_page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'total_record' => $iTotalRecords,
            'limit' => 3,
            'link_full' => Route::get('category/dashboard?page={page}'),
            'link_first' => Route::get('category/dashboard'),
            'range' => 5
        );
        //Init pagination
        Pagination::init($aConfig);
        $iTermsStart    = Pagination::$aConfig["start"];
        $iTermsLimit    = Pagination::$aConfig["limit"];
        $abCategoryInfo = TermsModel::getTermByTaxonomy(
            "category",
            $iTermsStart,
            $iTermsLimit
        );
        //If $abCategoryInfo=false, return empty array
        if (!$abCategoryInfo) {
            $abCategoryInfo = array();
        }
        //Handle ajax for pagination
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            die(json_encode(array("abCategoryInfo" => $abCategoryInfo, "paging" => Pagination::display())));
        }
        $this->loadView(
            "category/dashboard",
            $abCategoryInfo
        );
    }
    /**
     * Handle Add:after get data from ajax from page add/post
     */
    public function handleQuickAdd()
    {
        //Validate
        $bStatus = Validator::validate(
            array(
                "category_name" => "required|maxLength:10",
            ),
            $_POST
        );
        if ($bStatus !== true) {
            die($bStatus);
        }
        //Get $sTermName from $_POST-ajax
        $sTermName = isset($_POST) ? $_POST["category_name"] : "";
        //Check Category Exist
        if (TermsModel::checkTermNameExist("category", $sTermName)) {
            die("CATEGORY NAME EXIST");
        }
        $sSlug         = explode(" ", $sTermName);
        $sSlug         = array_map(
            function ($item) {
                return mb_strtolower($item, "UTF-8");
            },
            $sSlug
        );
        $sCategorySlug = implode($sSlug, "-");
        //Insert to Term Table
        $iStatusTerms = TermsModel::insertTerm($sTermName, $sCategorySlug);
        if (!$iStatusTerms) {
            Session::add(
                "category_error",
                "Oops! CATEGORY ADD TO TERM ERROR"
            );
            Redirect::to("post/add");
        }
        //Insert to Taxonomy Table
        $iStatusTaxonomy = TaxonomyModel::insertTaxonomy($iStatusTerms, "category", " ");
        if (!$iStatusTaxonomy) {
            Session::add(
                "category_error",
                "Oops! CATEGORY ADD TO TAXONOMY"
            );
            Redirect::to("post/add");
        }
        //Destroy Error
        Session::forget("category_error");
        //Handle Ajax
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            die($sTermName);
        }
    }
    /**
     *Handle Add:Afer press Add Category
     */
    public function handleAdd()
    {
        //Validate
        $bStatus = Validator::validate(
            array(
                "category-name" => "required|maxLength:10",
                "slug" => "maxLength:15",
                "description" => "maxLength:15"
            ),
            $_POST
        );
        if ($bStatus !== true) {
            Session::add("category_error", $bStatus);
            Redirect::to("category/add");
        }
        $sTermName = $_POST["category-name"];
        if ($_POST["slug"] == "") {
            $sSlug         = explode(" ", $sTermName);
            $sSlug         = array_map(
                function ($item) {
                    return mb_strtolower($item, "UTF-8");
                },
                $sSlug
            );
            $sCategorySlug = implode($sSlug, "-");
        } else {
            $sCategorySlug = $_POST["slug"];
        }
        $sDescription = $_POST["description"];
        //Check Category Exist
        if (TermsModel::checkTermNameExist("category", $sTermName)) {
            Session::add("category_error", "Oops! CATEGORY IS EXISTED");
            Redirect::to("category/add");
        }
        //Insert to term table
        $iStatusTerms = TermsModel::insertTerm($sTermName, $sCategorySlug);
        if (!$iStatusTerms) {
            Session::add(
                "category_error",
                "Oops! CATEGORY ADD TO TERM ERROR"
            );
            Redirect::to("category/add");
        }
        //Insert to Taxonomy Table
        $iStatusTaxonomy = TaxonomyModel::insertTaxonomy($iStatusTerms, "category", $sDescription);
        if (!$iStatusTaxonomy) {
            Session::add(
                "category_error",
                "Oops! CATEGORY ADD TO TAXONOMY ERROR"
            );
            Redirect::to("category/add");
        }
        //Destroy Error
        Session::forget("category_error");
        Redirect::to("category/dashboard");
    }
    /**
     * @throws \Exception
     */
    public function edit()
    {
        $this->middleware(['auth']);
        $sCategoryName = isset($_GET["category-name"]) ? $_GET["category-name"] : null;
        $aCategoryInfo = TermsModel::getTermByTermName($sCategoryName, "category");
        if (!$aCategoryInfo) {
            $aCategoryInfo = array();
        }
        $this->loadView("category/edit", $aCategoryInfo);
    }
    /**
     *HandleEdit:After press Change
     */
    public function handleEdit()
    {
        $sOldTermName = isset($_GET["category-name"]) ? $_GET["category-name"] : null;
        //Validate
        $bStatus = Validator::validate(
            array(
                "category-name" => "required|maxLength:10",
                "slug" => "maxLength:15",
                "description" => "maxLength:15"
            ),
            $_POST
        );
        if ($bStatus !== true) {
            Session::add("category_error", $bStatus);
            Redirect::to("category/edit?catgory-name=" . $sOldTermName);
        }
        $sTermName = $_POST["category-name"];
        if ($_POST["slug"] == "") {
            $sSlug         = explode(" ", $sTermName);
            $sSlug         = array_map(
                function ($item) {
                    return mb_strtolower($item, "UTF-8");
                },
                $sSlug
            );
            $sCategorySlug = implode($sSlug, "-");
        } else {
            $sCategorySlug = $_POST["slug"];
        }
        $sDescription = $_POST["description"];
        // Check Category Exist
        if (TermsModel::checkTermNameExist("category", $sTermName)) {
            Session::add("category_error", "Oops! CATEGORY IS EXISTED");
            Redirect::to("category/edit?category-name=" . $sOldTermName);
        }
        $iTermID = TermsModel::getTermByTermName($sOldTermName, "category");
        //Insert to Term Table
        $iStatusTerms = TermsModel::updateTerm($sTermName, $sCategorySlug, $sOldTermName);
        if (!$iStatusTerms) {
            Session::add(
                "category_error",
                "Oops! UPDATE CATEGORY TO TERM ERROR"
            );
            Redirect::to("category/edit?catgory-name=" . $sOldTermName);
        }
        //Insert to Taxonomy table
        $iStatusTaxonomy = TaxonomyModel::updateTaxonomy($sDescription, $iTermID);
        if (!$iStatusTaxonomy) {
            Session::add(
                "category_error",
                "Oops! UPDATE CATEGORY TO TAXONOMY ERROR"
            );
            Redirect::to("category/edit?catgory-name=" . $sOldTermName);
        }
        //Destroy Error
        Session::forget("category_error");
        Redirect::to("category/dashboard");
    }
    /**
     * Delete info category
     */
    public function delete()
    {
        //Get $iTermID
        $iTermID = isset($_POST["term_id"]) ? $_POST["term_id"] : null;
        //Delete Term table
        $aTermInfo = TermsModel::deleteTerm($iTermID);
        if ($aTermInfo) {
            echo "Delete Success";
        } else {
            echo "Delete Error";
        }
    }
}

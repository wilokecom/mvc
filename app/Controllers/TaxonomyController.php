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
 * Class Taxonomy Controller
 * @package MVC\Controllers
 */
class TaxonomyController extends Controller
{
    /**
     * Index: In the case, user do not write the method of class
     * @param $sTaxonomy
     */
    public function index($sTaxonomy)
    {
        if ($sTaxonomy) {
            Redirect::to($sTaxonomy . "/dashboard");
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
    /**
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function add($sTaxonomy)
    {
        $this->middleware(['auth']);
        if ($sTaxonomy) {
            $this->loadView($sTaxonomy . "/add");
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
    /**
     * Display dashboard of Taxonomy
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function dashboard($sTaxonomy)
    {
        $this->middleware(["auth"]);
        if ($sTaxonomy) {
            $iTotalRecords = TaxonomyModel::getRecordByTaxononmy($sTaxonomy);
            $aConfig       = array(
                'current_page' => isset($_GET['page']) ? $_GET['page'] : 1,
                'total_record' => $iTotalRecords,
                'limit' => 3,
                'link_full' => Route::get($sTaxonomy . '/dashboard?page={page}'),
                'link_first' => Route::get($sTaxonomy . '/dashboard'),
                'range' => 5
            );
            //Init pagination
            Pagination::init($aConfig);
            $iTermsStart    = Pagination::$aConfig["start"];
            $iTermsLimit    = Pagination::$aConfig["limit"];
            $abTaxonomyInfo = TermsModel::getTermByTaxonomy(
                $sTaxonomy,
                $iTermsStart,
                $iTermsLimit
            );
            //If $abTaxonomyInfo=false, return empty array
            if (!$abTaxonomyInfo) {
                $abTaxonomyInfo = array();
            }
            //Handle ajax for pagination
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {
                die(
                    json_encode(
                        array(
                            "sTaxonomy" => $sTaxonomy,
                            "abTaxonomyInfo" => $abTaxonomyInfo,
                            "paging" => Pagination::display()
                        )
                    )
                );
            }
            $this->loadView(
                $sTaxonomy . "/dashboard",
                $abTaxonomyInfo
            );
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
    /**
     * Handle Add:after get data from ajax from page add/post
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function handleQuickAdd($sTaxonomy)
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //Validate
            $bStatus = Validator::validate(
                array(
                    $sTaxonomy . "_name" => "required|maxLength:10",
                ),
                $_POST
            );
            if ($bStatus !== true) {
                die($bStatus);
            }
            //Get $sTermName from $_POST-ajax
            $sTermName = isset($_POST) ? $_POST[$sTaxonomy . "_name"] : "";
            //Check Taxonomy Exist
            if (TermsModel::checkTermNameExist($sTaxonomy, $sTermName)) {
                die(strtoupper($sTaxonomy) . "NAME EXIST");
            }
            $sSlug         = explode(" ", $sTermName);
            $sSlug         = array_map(
                function ($item) {
                    return mb_strtolower($item, "UTF-8");
                },
                $sSlug
            );
            $sTaxonomySlug = implode($sSlug, "-");
            //Insert to Term Table
            $iStatusTerms = TermsModel::insertTerm($sTermName, $sTaxonomySlug);
            if (!$iStatusTerms) {
                die("Oops!" . strtoupper($sTaxonomy) . " ADD TO TERM ERROR");
            }
            //Insert to Taxonomy Table
            $iStatusTaxonomy = TaxonomyModel::insertTaxonomy($iStatusTerms, $sTaxonomy, " ");
            if (!$iStatusTaxonomy) {
                die("Oops!" . strtoupper($sTaxonomy) . "ADD TO TAXONOMY ERROR");
            }
            //Handle Ajax
            die($sTermName);
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
    /**
     * Handle Add:Afer press Add Category/Tag...
     * @param $sTaxonomy
     */
    public function handleAdd($sTaxonomy)
    {
        if ($sTaxonomy&&$_POST) {
            //Validate
            $bStatus = Validator::validate(
                array(
                    $sTaxonomy . "-name" => "required|maxLength:10",
                    "slug" => "maxLength:15",
                    "description" => "maxLength:15"
                ),
                $_POST
            );
            if ($bStatus !== true) {
                Session::add($sTaxonomy . "_error", $bStatus);
                Redirect::to($sTaxonomy . "/add");
            }
            $sTermName = $_POST[$sTaxonomy . "-name"];
            if ($_POST["slug"] == "") {
                $sSlug         = explode(" ", $sTermName);
                $sSlug         = array_map(
                    function ($item) {
                        return mb_strtolower($item, "UTF-8");
                    },
                    $sSlug
                );
                $sTaxonomySlug = implode($sSlug, "-");
            } else {
                $sTaxonomySlug = $_POST["slug"];
            }
            $sDescription = $_POST["description"];
            //Check Taxonomy Exist
            if (TermsModel::checkTermNameExist($sTaxonomy, $sTermName)) {
                Session::add($sTaxonomy . "_error", "Oops!" . strtoupper($sTaxonomy) . " IS EXISTED");
                Redirect::to("$sTaxonomy/add");
            }
            //Insert to term table
            $iStatusTerms = TermsModel::insertTerm($sTermName, $sTaxonomySlug);
            if (!$iStatusTerms) {
                Session::add(
                    $sTaxonomy . "_error",
                    "Oops! " . strtoupper($sTaxonomy) . " ADD TO TERM ERROR"
                );
                Redirect::to("/add");
            }
            //Insert to Taxonomy Table
            $iStatusTaxonomy = TaxonomyModel::insertTaxonomy($iStatusTerms, $sTaxonomy, $sDescription);
            if (!$iStatusTaxonomy) {
                Session::add(
                    $sTaxonomy . "_error",
                    "Oops! " . strtoupper($sTaxonomy) . " ADD TO TAXONOMY ERROR"
                );
                Redirect::to($sTaxonomy . "/add");
            }
            //Destroy Error
            Session::forget($sTaxonomy . "_error");
            Redirect::to($sTaxonomy . "/dashboard");
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
    /**
     * @return mixed
     * @param $sTaxonomy
     * @throws \Exception
     */
    public function edit($sTaxonomy)
    {
        $this->middleware(['auth']);
        if ($sTaxonomy) {
            $this->middleware(['auth']);
            $sTaxonomyName = isset($_GET[$sTaxonomy . "-name"]) ? $_GET[$sTaxonomy . "-name"] : null;
            $aTaxonomyInfo = TermsModel::getTermByTermName($sTaxonomyName, $sTaxonomy);
            if (!$aTaxonomyInfo) {
                $aTaxonomyInfo = array();
            }
            $this->loadView($sTaxonomy . "/edit", $aTaxonomyInfo);
        } else {
            header("HTTP/1.0 404 Not Found");
            return Message::error('', 404);
        }
    }
    /**
     * HandleEdit:After press Change
     * @param $sTaxonomy
     */
    public function handleEdit($sTaxonomy)
    {
        if ($sTaxonomy) {
            $sOldTermName = isset($_GET[$sTaxonomy . "-name"]) ? $_GET[$sTaxonomy . "-name"] : null;
            //Validate
            $bStatus = Validator::validate(
                array(
                    $sTaxonomy . "-name" => "required|maxLength:10",
                    "slug" => "maxLength:15",
                    "description" => "maxLength:15"
                ),
                $_POST
            );
            if ($bStatus !== true) {
                Session::add($sTaxonomy . "_error", $bStatus);
                Redirect::to($sTaxonomy . "/edit?" . $sTaxonomy . "-name=" . $sOldTermName);
            }
            $sTermName = $_POST[$sTaxonomy . "-name"];
            if ($_POST["slug"] == "") {
                $sSlug         = explode(" ", $sTermName);
                $sSlug         = array_map(
                    function ($item) {
                        return mb_strtolower($item, "UTF-8");
                    },
                    $sSlug
                );
                $sTaxonomySlug = implode($sSlug, "-");
            } else {
                $sTaxonomySlug = $_POST["slug"];
            }
            $sDescription = $_POST["description"];
            // Check Taxonomy Exist
            if (TermsModel::checkTermNameExist($sTaxonomy, $sTermName)) {
                Session::add($sTaxonomy . "_error", "Oops!" . strtoupper($sTaxonomy) . "IS EXISTED");
                Redirect::to($sTaxonomy . "/edit?" . $sTaxonomy . "-name=" . $sOldTermName);
            }
            $iTermID = TermsModel::getTermByTermName($sOldTermName, $sTaxonomy);
            //Insert to Term Table
            $iStatusTerms = TermsModel::updateTerm($sTermName, $sTaxonomySlug, $sOldTermName);
            if (!$iStatusTerms) {
                Session::add(
                    $sTaxonomy . "_error",
                    "Oops! UPDATE" . strtoupper($sTaxonomy) . "TO TERM ERROR"
                );
                Redirect::to($sTaxonomy . "/edit?" . $sTaxonomy . "-name=" . $sOldTermName);
            }
            //Insert to Taxonomy table
            $iStatusTaxonomy = TaxonomyModel::updateTaxonomy($sDescription, $iTermID);
            if (!$iStatusTaxonomy) {
                Session::add(
                    $sTaxonomy . "_error",
                    "Oops! UPDATE" . strtoupper($sTaxonomy) . "TO TAXONOMY ERROR"
                );
                Redirect::to($sTaxonomy . "/edit?" . $sTaxonomy . "-name=" . $sOldTermName);
            }
            //Destroy Error
            Session::forget($sTaxonomy . "_error");
            Redirect::to($sTaxonomy . "/dashboard");
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
    /**
     * Delete Info Taxonomy
     */
    public function delete()
    {
        //Handle Ajax
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            //Get $iTermID
            $iTermID = isset($_POST["term_id"]) ? $_POST["term_id"] : null;
            //Delete Term table
            $aTermInfo = TermsModel::deleteTerm($iTermID);
            if ($aTermInfo) {
                echo "Delete Success";
            } else {
                echo "Delete Error";
            }
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    }
}

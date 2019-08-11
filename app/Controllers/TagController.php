<?php
/**
 * Created by PhpStorm.
 * User: doduc
 * Date: 31/07/2019
 * Time: 3:34 CH
 */
namespace MVC\Controllers;

use MVC\Models\TermsModel;
use MVC\Models\TaxonomyModel;
use MVC\Support\Redirect;
use MVC\Support\Pagination;
use MVC\Support\Route;
use MVC\Support\Session;
use MVC\Support\Validator;

/**
 * Class TagController
 * @package MVC\Controllers
 */
class TagController extends Controller
{
    public function index()
    {
        Redirect::to('tag/dashboard');
    }

    public function dashboard()
    {

    }

    public function handleadd()
    {

    }
}

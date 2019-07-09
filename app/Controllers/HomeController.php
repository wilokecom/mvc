<?php declare(strict_types=1);
namespace MVC\Controllers;

/**
 * Class HomeController
 * @package MVC\Controllers
 */
class HomeController extends Controller
{
    /**
     * Go to method loadView of Class Controller
     * @throws \Exception
     */
    public function index()
    {
        $this->loadView("home/index");
    }
}

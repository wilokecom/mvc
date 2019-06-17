<?php
namespace MVC\Controllers;

/**
 * Class HomeController
 *
 * @package MVC\Controllers
 */
class HomeController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        //Nhảy đến phương thức loadView của Class Controller
        $this->loadView("home/index");
    }
}

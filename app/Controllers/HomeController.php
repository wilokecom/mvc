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
     * Nhảy đến phương thức loadView của Class Controller
     * @throws \Exception
     */
    public function index()
    {
        $this->loadView("home/index");
    }
}

<?php
namespace MVC\Controllers;

class HomeController extends Controller {
	public function index(){
	    //Nhảy đến phương thức loadView của Class Controller
		$this->loadView('home/index');
	}

}
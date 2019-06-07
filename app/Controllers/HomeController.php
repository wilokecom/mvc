<?php
namespace MVC\Controllers;

class HomeController extends Controller {
	public function index(){
		$this->loadView('home/index');
	}
//	public function login(){
//	    $this->loadView('home/login');
//    }
}
//'home/index'
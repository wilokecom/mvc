<?php
namespace MVC\Controllers;

class HomeController extends Controller {
	public function index(){
		$this->loadView('home/index');
	}
}
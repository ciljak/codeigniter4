<?php

namespace App\Controllers;

class About extends BaseController
{
	public function index()
	{
        //$this->load->helper('url'); // loading helper for linking css and js files located in views as url.php referencing into a css and js folder
        echo view('templates/header');  // if page consist from parts of tepmplate dont use return but echo appropriate parts!!
		echo view('about');
        echo view('templates/footer');
	}
}

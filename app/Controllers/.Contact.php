<?php

namespace App\Controllers;

class Contact extends BaseController
{
	public function index()
	{
        echo view('templates/header');
        echo view('contact');
        echo view('templates/footer');
	}
}

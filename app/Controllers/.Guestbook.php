<?php

namespace App\Controllers;

class Guestbook extends BaseController
{
	public function index()
	{
        echo view('templates/header');
        echo view('guestbook');
        echo view('templates/footer');
	}
}

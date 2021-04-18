<?php

namespace App\Controllers;

class Guestbook extends BaseController
{
	public function index()
	{
        echo view('header');
        echo view('guestbook');
        echo view('footer');
	}
}

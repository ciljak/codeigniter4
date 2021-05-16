<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		$data = [];

		/* alternate way how to disable access to loget out user from dashboard 
		if(!session()-> get('isLogedIn'))
		   redirect()->to('/')
		
		*/

		echo view('templates/header', $data);
		echo view('users/dashboard');
		echo view('templates/footer');
	}

	//--------------------------------------------------------------------

}

<?php
namespace App\Http\Controllers;

use Atl\Routing\Controller as baseController;
use Atl\Validation\Validation;

class LoginController extends baseController{

	public function login(){
		// Load layout.
		return view(
			'login.tpl',
			[
				
			]
		);
	}

	public function logout(){

	}
}
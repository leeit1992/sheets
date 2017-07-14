<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;
use Atl\Validation\Validation;

class UserController extends baseController{

	public function saveUser(){

		// Load layout.
		return $this->loadTemplate(
			'user/addUser.tpl',
			[
				
			]
		);
	}

	public function manageUser(){
		// Load layout.
		return $this->loadTemplate(
			'user/manageUser.tpl',
			[
				
			]
		);
	}
}
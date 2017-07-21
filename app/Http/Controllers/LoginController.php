<?php
namespace App\Http\Controllers;

use Atl\Routing\Controller as baseController;
use Atl\Validation\Validation;
use Atl\Foundation\Request;

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
		redirect( url('/login') );
	}

	public function checkLogin(Request $request){
		if( 'admin@gmail.com' == $request->get('op_login_acc') &&  'admin' == $request->get('op_login_pass') ) {
			redirect( url('/') );
		}
	}
}
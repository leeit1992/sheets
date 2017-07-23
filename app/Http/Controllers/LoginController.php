<?php
namespace App\Http\Controllers;

use Atl\Foundation\Request;
use Atl\Validation\Validation;

use App\Http\Components\Controller as baseController;
use App\Model\UserModel;

class LoginController extends baseController{

	public function __construct(){
		parent::__construct();
	}

	public function login(){

		if (true === Session()->has('op_user_id')) {
            redirect( url( '/' ) );
            return true;
        }

		// Load layout.
		return view(
			'login.tpl',
			[
				'noticeLogin' => Session()->getFlashBag()->get('loginError')
			]
		);
	}

	public function checkLogin(Request $request){

		$validator = new Validation;
		$validator->add(
			[
				'op_login_acc:Account'   => 'email | required | minlength(6)',
				'op_login_pass:Password' => 'required | minlength(4)',
			]
		);

		$error = [];

		if ($validator->validate($_POST)) {
			$user = new UserModel();

			$checkUser = $user->checkLogin( $request->get('op_login_acc'), md5( $request->get('op_login_pass') ) );
			
			if( !empty( $checkUser ) ) {
				Session()->set('op_user_id', $checkUser[0]['id']);
				Session()->set('op_user_name', $checkUser[0]['user_name']);
				Session()->set('op_user_email', $checkUser[0]['user_email']);
				Session()->set('op_user_meta',  $user->getAllMetaData( $checkUser[0]['id'] ) );

				$this->mdLogs->add( $this->mdLogs->logTemplate( ' User <b> ' . $checkUser[0]['user_email'] . ' </b>', 'Login' ) );

				redirect( url( '/' ) );
			}else{
				$error[] = 'error';
			}
		} else{
			$error[] = 'error';
		}

		if( !empty( $error ) ) {
			Session()->getFlashBag()->set('loginError', 'Account or Password not match !');
			redirect( url( '/login' ) );
		}
	}

	public function logout(){
		$this->mdLogs->add( $this->mdLogs->logTemplate( ' User <b> ' . Session()->get('op_user_email') . ' </b>', 'logout' ) );
		Session()->remove('op_user_id');
		Session()->remove('op_user_name');
		Session()->remove('op_user_email');

		redirect( url( '/login' ) );
	}

}
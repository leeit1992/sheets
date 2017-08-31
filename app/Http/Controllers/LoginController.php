<?php
namespace App\Http\Controllers;

use Atl\Foundation\Request;
use Atl\Validation\Validation;

use App\Http\Components\Controller as baseController;
use App\Model\UserModel;
use App\Model\SheetModel;
use PHPMailer;

class LoginController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->mdUser = new UserModel;
		$this->mdSheet = new SheetModel;
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
				if( 1 == $checkUser[0]['user_status'] ) {

					$userMeta = $user->getAllMetaData( $checkUser[0]['id'] );

					Session()->set('op_user_id', $checkUser[0]['id']);
					Session()->set('op_user_name', $checkUser[0]['user_name']);
					Session()->set('op_user_email', $checkUser[0]['user_email']);
					Session()->set('op_user_meta', $userMeta );

					$this->mdLogs->add( $this->mdLogs->logTemplate( ' User <b> ' . $checkUser[0]['user_email'] . ' </b>', 'Login' ) );

					if( 1 == $userMeta['user_role'] ) {
						redirect( url( '/' ) );
					}

					if( 2 == $userMeta['user_role'] or 3 == $userMeta['user_role'] ) {
						$listSheets = $this->mdSheet->getBy(['sheet_author' => $checkUser[0]['id']]);
						if( !empty( $listSheets ) ) {
							redirect( url( '/view-sheet/'. $listSheets[0]['id'] ) );
						}else{
							die;
						}
					}
					
				}else{
					$error[] = 'error';
					Session()->getFlashBag()->set('loginError', 'Account is not activated. Go to mail to receive activation mail !');
				}
				
			}else{
				$error[] = 'error';
				Session()->getFlashBag()->set('loginError', 'Account or Password not match !');
			}
		} else{
			$error[] = 'error';
			Session()->getFlashBag()->set('loginError', 'Wrong account or password !');
		}

		if( !empty( $error ) ) {
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

	public function registerUser(Request $request){

		if( !empty( $request->get('formdata') ) ) {
			parse_str($request->get('formdata'), $formData);
			
			
			$userCode = $this->slug( $formData['register_username'] . '-' . $formData['register_code'] );
			$userCode = strtoupper( $userCode );

			// Save user.
			$emailExists = $this->mdUser->getUserBy( 'user_email', $formData['register_email'] );
			$codelExists = $this->mdUser->getUserBy( 'user_code', $userCode );

			if( empty( $emailExists ) && empty( $codelExists ) ) {
				$status = true;

				/**
				 * Insert
				 */
				$token = uniqid();
				$lastID = $this->mdUser->save( 
					[
						'user_name'         => $formData['register_username'],
						'user_password'     => md5( $formData['register_password'] ),
						'user_email'        => $formData['register_email'],
						'user_registered'   => date("Y-m-d H:i:s"),
						'user_status'       => 0,
						'user_display_name' => ucfirst($formData['register_username']),
						'user_token'        => $token,
						'user_code'         => $userCode,
						'user_color'        => isset( $formData['register_color'] ) ? $formData['register_color'] : '',
					]
				);

				for ($i=0; $i < 6; $i++) { 
					$this->addSheetDefault(
						$lastID,
						[
							'sheetTitle' => $this->slug( $formData['register_username'] . '-' . $i )
						]
					);
				}

				/**
				 * Add meta data for user.
				 */
				$userMeta = [
					'user_birthday' => '',
					'user_address'  => '',
					'user_moreinfo' => '',
					'user_phone'    => '',
					'user_social'   => '',
					'user_role'     => 2,
				];

				// Loop add add
				foreach ($userMeta as $mtaKey => $metaValue) {
					$this->mdUser->setMetaData( $lastID, $mtaKey, $metaValue );
				}

				$mail = new PHPMailer;
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'letrungha.192@gmail.com';                 // SMTP username
				$mail->Password = 'dtnncmmnidifocjn';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect to

				$mail->setFrom($formData['register_email'], 'Active account');
				$mail->addAddress($formData['register_email'], $formData['register_username']);     // Add a recipient
				$mail->addReplyTo($formData['register_email'], 'Information');

				$mail->Subject = 'Active account';

				$link = '<a href="'.url('/active-account/' . $token).'"> Here </a>';
				$mail->isHTML(true); 
				
				$mail->Body    = 'Congratulations on signing up for a successful account. Please click '.$link.' to activate your account.';
				$mail->send();

				$output = 'Register success.';
			}else{
				$status = false;

				if( !empty( $emailExists ) ) {
					$output = 'Email already exists.';
				}

				if( !empty( $codelExists ) ) {
					$output = 'Code already exists.';
				}
				
			}

			echo json_encode([
				'status' => $status,
				'output' => $output
			]);
		}
	}

	public function addSheetDefault( $uerId, $args ){
		$lastID = $this->mdSheet->save(
			[
				'sheet_title'   => $args['sheetTitle'],
				'sheet_description' => '',
				'sheet_content' => '[]',
				'sheet_author'  => $uerId,
				'sheet_datetime' => date("Y-m-d H:i:s"),
				'sheet_status'  => 1
			]
		);

		/**
		 * Add meta data for user.
		 */
		$sheetMeta = [
			'sheet_meta' => '[]',
		];

		// Loop add add | update meta data.
		foreach ($sheetMeta as $mtaKey => $metaValue) {
			$this->mdSheet->setMetaData( $lastID, $mtaKey, $metaValue );
		}

	}

	public function activeAccount(Request $request, $token){
		if( isset( $token ) ) {
			$checkUser = $this->mdUser->getUserBy( 'user_token', $token );

			if( !empty( $checkUser ) ) {

				$this->mdUser->save( 
					[
						'user_status'       => 1,
						'user_token'        => ''
					],
					$checkUser[0]['id']
				);

				$message = 'User <strong>' . $checkUser[0]['user_name'] . '</strong> with account <strong>' . $checkUser[0]['user_email'] . '</strong> active sucess!';
			}else{
				$message = 'Token do not exists.';
			}
		}

		View('activeAccount.tpl', [ 'message' => $message ]);
	}

}
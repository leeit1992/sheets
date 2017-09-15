<?php
namespace App\Http\Controllers;

use Atl\Foundation\Request;
use Atl\Validation\Validation;

use App\Http\Components\Controller as baseController;
use App\Model\UserModel;
use App\Model\LogsModel;
use Atl\Pagination\Pagination;
use App\Model\SheetModel;

class UserController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->userAccess();
		$this->userRole();

		// Model data system.
		$this->mdUser = new UserModel;
		$this->mdLogs = new LogsModel;
		$this->mdSheet = new SheetModel;
	}

	/**
	 * Handle display manage users.
	 * 
	 * @param  int $page  Number of page.
	 * @return string
	 */
	public function manageUsers( $page = null ){
		$ofset                = 10;
        $config['pageStart']  = $page;
        $config['ofset']      = $ofset;
        $config['totalRow']   = $this->mdUser->count();
        $config['baseUrl']    = url('/atl-admin/manage-user/page/');
        $config['classes']    = 'uk-pagination uk-margin-medium-top';
        $config['nextLink']   = '<i class="uk-icon-angle-double-right"></i>';
        $config['prevLink']   = '<i class="uk-icon-angle-double-left"></i>';
        $config['tagOpenPageCurrent']   = '<li class="uk-active"><span>';
        $config['tagClosePageCurrent']  = '<span></li>';
        $config['tagOpen']    = '';
        $config['tagClose']   = '';

        $pagination           = new Pagination($config);

		return $this->loadTemplate(
			'user/manageUser.tpl',
			[	
				'listUser'   => $this->mdUser->getUserLimit( $pagination->getStartResult( $page ), $ofset ),
				'pagination' => $pagination->link(),
				'mdUser'     => $this->mdUser
			]
		);
	}

	/**
	 * Handle display add | edit user.
	 * 
	 * @param  int $id ID of user edit.
	 * @return string
	 */
	public function handleUser( $id = null ){

		registerStyle( [
		    'spectrum'     => assets('bower_components/spectrum/spectrum.css'),
		] ); 

		$infoUser   = array();
		$metaData   = array();
		$userSocial = array();

		// Load data user by action edit user.
		if( $id ) {
			$infoUser   = $this->mdUser->getUserBy( 'id', $id );
			$metaData   = $this->mdUser->getAllMetaData( $id );
			$userSocial = ( array ) json_decode( $metaData['user_social'] );

			if( empty( $infoUser ) ) {
				redirect( url('/error-404?url=' . $_SERVER['REDIRECT_URL']) );
			}
		}

		if( 1 != $this->infoUser['meta']['user_role'] ) {
			if( $id != $this->infoUser['id'] ){
				redirect( url('/error-404?url=' . $_SERVER['REDIRECT_URL']) );
			}
		}

		// Load template
		return $this->loadTemplate(
			'user/addUser.tpl',
			[
				'user'   => !empty( $infoUser[0] ) ? $infoUser[0] : array(),
				'meta'   => $metaData,
				'actionName' => ( !$id ) ? 'Created User' : $infoUser[0]['user_name'],
				'infoUser' => $this->infoUser,
				'social' => $userSocial,
				'mdUser' => $this->mdUser,
				'notify' => Session()->getFlashBag()->get('userFormNotice'),
				'self'   => $this
			]
		);
	}

	/**
	 * Handle validate form user.
	 * 
	 * @param  Request $request Request POST | GET method
	 * @return void.
	 */
	public function validateUser(Request $request){
		
		if( !empty( $request->get('formData') ) ) {
			parse_str($request->get('formData'), $formData);

			$notice    = array();
			$validator = new Validation;

			// Check validate user.
			$validator->add(
				[
					'atl_user_email:Email'     => 'required | minlength(6)',
					'atl_user_pass:Password'   => 'required | minlength(6)',
					'atl_user_cf_pass:Confirm' => 'required | minlength(6) | match(item=atl_user_pass)',
				]
			);

			if ( $validator->validate( $formData ) ) {

				// Save user.
				$emailExists = $this->mdUser->getUserBy( 'user_email', $formData['atl_user_email'] );
				$emailExists = isset( $formData['atl_user_id'] ) ? array() : $emailExists;

				if( empty( $emailExists ) ) {
					
					$userCode = $this->slug( $formData['atl_user_name'] . '-' . $formData['atl_user_code'] );
					$userCode = strtoupper( $userCode );
					$usercolor = isset( $formData['atl_user_color'] ) ? $formData['atl_user_color'] : '';

					if( isset( $formData['atl_user_id'] ) ) {
						$currentUser = $this->mdUser->getUserBy( 'id', $formData['atl_user_id'] );
						$userCode = $currentUser[0]['user_code'];
						$usercolor = $currentUser[0]['user_color'];
					}

					/**
					 * Insert | Update user.
					 */
					
					$argsSave = [
							'user_name'         => empty( $formData['atl_user_name'] ) ? $formData['atl_user_email'] : $formData['atl_user_name'],
							'user_password'     => $this->isValidMd5($formData['atl_user_pass']) ? $formData['atl_user_pass'] : md5( $formData['atl_user_pass'] ),
							'user_registered'   => date("Y-m-d H:i:s"),

							'user_display_name' => empty( $formData['atl_user_name'] ) ? $formData['atl_user_email'] : $formData['atl_user_name'],
							'user_code'         => $userCode,
							'user_color'        => $usercolor,
						];

					if( !isset( $formData['atl_user_id'] ) or 1 == $this->infoUser['meta']['user_role'] ) {
						$argsSave['user_email'] = $formData['atl_user_email'];
						$argsSave['user_status'] = !empty( $formData['atl_user_status'] ) ? $formData['atl_user_status'] : 0;
					}

					$lastID = $this->mdUser->save( 
						$argsSave,
						isset( $formData['atl_user_id'] ) ? $formData['atl_user_id'] : null
					);
					
					if( !isset( $formData['atl_user_id'] ) ) {
						for ($i = 0; $i < 6; $i++) { 
							$this->addSheetDefault($lastID, 
								[
									'sheetTitle' => $formData['atl_user_name'] . ' ' . $i,
									'sheetContent' => $this->autoCreatDataSheetEmpty()
								]
							);
						}
					}
					
					/**
					 * Upload avatar
					 */
					$linkAvatar = isset( $formData['atl_user_avatar'] ) ? $formData['atl_user_avatar'] : null;
					if( !empty( $request->files->get('avatar') ) ) {
						
						$dir = FOLDER_UPLOAD . '/avatar_user';

						// Check if dir.
						if( !is_dir( $dir ) ) {
							mkdir( $dir );
						}

						// Custom link avatar.
						$linkAvatar =  '/uploads/avatar_user/avatar-user-' . $lastID . '.png';
						
						// Move to folder upload.
						$request->files->get('avatar')->move( $dir, 'avatar-user-' . $lastID . '.png' );
					}

					/**
					 * Add meta data for user.
					 */
					$userMeta = [
						'user_birthday' => $formData['atl_user_birthday'],
						'user_address'  => $formData['atl_user_address'],
						'user_moreinfo' => $formData['atl_user_moreinfo'],
						'user_phone'    => $formData['atl_user_phone'],
						'user_social'   => $formData['atl_user_social'],
						'user_avatar'   => $linkAvatar,
					];

					if( !isset( $formData['atl_user_id'] ) or 1 == $this->infoUser['meta']['user_role'] ) {
						$userMeta['user_role'] = $formData['atl_user_role'];
					}

					// Loop add add | update meta data.
					foreach ($userMeta as $mtaKey => $metaValue) {
						$this->mdUser->setMetaData( $lastID, $mtaKey, $metaValue );
					}

					// Set notice success
					$nameAction = isset( $formData['atl_user_id'] ) ? 'Update' : 'Create';
					Session()->getFlashBag()->set( 'userFormNotice', $nameAction . ' account successfully' );

					$this->mdLogs->add( $this->mdLogs->logTemplate( $nameAction . ' User <b> ' . $formData['atl_user_email'] . ' </b>', 'User' ) );

					// Set notice success
					$notice['id']      = $lastID;
					$notice['status']  = true;

				}else{

					// Set notice error
					$notice['status']    = false;
					$notice['message'][] = 'This account already exists.';
				}
				
			} else {

				$notice['status']  = false;
				foreach ($validator->getAllErrors() as $value) {
					$notice['message'][] = $value;
				}
			}

			echo json_encode($notice);
		}	
	}

	/**
	 * Handle filter user
	 * 
	 * @param  Request $request POST | GET
	 * @return json
	 */
	public function ajaxManageUser(Request $request){
		$output = '';

		/**
		 * Check type get list user manage.
		 */
		switch ( $request->get('getBy') ) {
			case 'role':
				ob_start();
				$output .= View(
					'user/manageUserJs.tpl',
					[
						'users'  => $this->mdUser->getAllUserByMeta( 'user_role', $request->get('roleStatus') ),
						'mdUser' => $this->mdUser,
					]
				);
				$output .= ob_get_clean();
				break;
			case 'search':
				ob_start();
				$output .= View(
					'user/manageUserJs.tpl',
					[
						'users'  => $this->mdUser->searchBy( $request->get('keyup') ),
						'mdUser' => $this->mdUser,
					]
				);
				$output .= ob_get_clean();
				break;
		}

		echo json_encode( 
			[
				'output' => $output
			]
		);
	}

	/**
	 * Handle delete user with ajax
	 * 
	 * @param  Request $request POST | GET
	 * @return void
	 */
	public function ajaxDelete(Request $request){
		$id = $request->get('id');
		// Remove user
		$output = $this->mdUser->delete( $id );
		// Remove metadata
		$this->mdUser->deleteMetaData( $id );
		
		if (is_array($id)) {
			//Loop list user_id
			foreach ($id as $value) {
				// Custom link avatar
				$linkAvatar =  FOLDER_UPLOAD . '/avatar_user/avatar-user-' . $value . '.png';
				//Check file avatar and delete
				if (file_exists($linkAvatar)) {
					unlink($linkAvatar);
				}

				$this->mdSheet->deleteByAuthor($value);
			}
		}else{
			$linkAvatar =  FOLDER_UPLOAD . '/avatar_user/avatar-user-' . $id . '.png';
			if (file_exists($linkAvatar)) {
				unlink($linkAvatar);
			}
			$this->mdSheet->deleteByAuthor($id);
		}
		$message['status'] = true;
		if( empty( $request->get('id') ) ){
			$message['status'] = false;
		}

		echo json_encode(
			$message
		);
	}

	public function addSheetDefault( $uerId, $args ){
		$lastID = $this->mdSheet->save(
			[
				'sheet_title'   => $args['sheetTitle'],
				'sheet_description' => '',
				'sheet_content' => isset( $args['sheetContent'] ) ? json_encode($args['sheetContent']) : '[]',
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

}
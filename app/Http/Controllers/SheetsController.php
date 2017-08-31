<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;
use Atl\Foundation\Request;
use App\Model\SheetModel;
use App\Model\UserModel;
use App\Model\MessagesModel;

class SheetsController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->userAccess();

		$this->mdSheet = new SheetModel;
		$this->mdUser = new UserModel;
		$this->mdMessages = new MessagesModel;
	}

	public function handleSheet( $id = null ){
		
		registerStyle( [
		    'handsontable' => assets('bower_components/handsontable/handsontable.full.min.css'),
		    'spectrum'     => assets('bower_components/spectrum/spectrum.css'),
		    'samples'     => 'http://handsontable.github.io/handsontable-ruleJS/css/samples.css',
		] ); 

		$sheets = array();
		$sheetShareStatus = false;

		if( $id ) {
			$condition = [ 
					'id' => $id
				];

			if( 2 == $this->infoUser['meta']['user_role'] ) {
				$condition['sheet_author'] = Session()->get('op_user_id');
			}

			$sheets = $this->mdSheet->getBy( 
				$condition
			);

			$sheetShare = $this->mdSheet->getBy( 
				['id' => $id]
			);

			if( isset( $sheetShare[0]['sheet_share'] ) ) {
				$listShare = json_decode( $sheetShare[0]['sheet_share'] );

				if( in_array(Session()->get('op_user_id'), $listShare) ) {
					$sheets = $sheetShare;
					$sheetShareStatus = true;
				}else{
					if( empty( $sheets ) ) {
						redirect( url('/error-404?url=' . $_SERVER['REDIRECT_URL']) );
					}
				}

			}else{
				if( empty( $sheets ) ) {
					redirect( url('/error-404?url=' . $_SERVER['REDIRECT_URL']) );
				}
			}

		}else{
			$autoRedirect = $this->mdSheet->getBy(['sheet_author' => Session()->get('op_user_id')]);

			if( !empty( $autoRedirect ) ) {
				redirect( url('/view-sheet/' . $autoRedirect[0]['id'] ) );
			}
		}

		$listSheets = $this->mdSheet->getBy( [
			'sheet_author' => Session()->get('op_user_id')
		] );

		// Load layout.
		return $this->loadTemplate(
			'sheet/sheet.tpl',
			[
				'infoUser' => $this->infoUser,
				'sheet'  => $sheets,
				'mdUser' => $this->mdUser,
				'mdMessages' => $this->mdMessages,
				'listSheets' => $listSheets,
				'sheetShareStatus' => $sheetShareStatus,
			]
		);
	}

	public function manageSheets(){
		$condition = [ 
					'ORDER' => [
						'id' => 'DESC'
					]
				];
		if( 1 != $this->infoUser['meta']['user_role'] ) {
			$condition['sheet_author'] = Session()->get('op_user_id');
		}

		$listSheets = $this->mdSheet->getBy( $condition );

		// Load layout.
		return $this->loadTemplate(
			'sheet/manageSheets.tpl',
			[
				'listSheets' => $listSheets,
				'mdUser'     => $this->mdUser,
			]
		);
	}

	public function saveSheets(Request $request){
		$author  = Session()->get('op_user_id');
		$sheetId = null;

		if( !empty( $request->get('sheetId') ) && 'new' != $request->get('saveType') ) {
			$sheetAuthor = $this->mdSheet->getBy(['id' => $request->get('sheetId') ]);

			if( !empty( $sheetAuthor ) ) {
				$author = $sheetAuthor[0]['sheet_author'];
			}

			$sheetId = $request->get('sheetId');
		}

		$currentDataSheet = $request->get('sheetData');

		if( 1 == $this->infoUser['meta']['user_role'] ) {
			$currentDataSheet = json_decode($request->get('sheetData'));
				
			// remove emptry
			foreach ($currentDataSheet as $key => $value) {
				if( empty( $value[0] ) ) {
					unset($currentDataSheet[$key]);
				}
			}
		}
		

		$lastID = $this->mdSheet->save(
			[
				'sheet_content' => json_encode($currentDataSheet),
				'sheet_author'  => $author,
				'sheet_datetime' => date("Y-m-d H:i:s"),
				'sheet_status'  => 1
			],
			$sheetId
		);

		$receiver = $request->get('sheetReceiver');


		/**
		 * Add meta data for user.
		 */
		$sheetMeta = [
			'sheet_meta' => $request->get('sheetMeta'),
		];

		// Loop add add | update meta data.
		foreach ($sheetMeta as $mtaKey => $metaValue) {
			$this->mdSheet->setMetaData( $lastID, $mtaKey, $metaValue );
		}

		$action = !empty( $request->get('sheetId') )  ? 'Update' : 'Created';
		// Set notice success
		$this->mdLogs->add($this->mdLogs->logTemplate( $action . ' sheets', 'Sheets'));
	}

	public function getSheets(Request $request){
		$sheets = $this->mdSheet->getBy( [ 'sheet_author' => Session()->get('op_user_id'), 'id' => $request->get('id') ] );

		if( !empty( $sheets ) ) {

			$data = json_decode( $sheets[0]['sheet_content'] );
			$message = true;

		}else{
			$message = false;
		}

		echo json_encode(
			[
				'data'   => $data,
				'status' => $message
			]
		);
	}

	public function sendSheet(Request $request){

		$this->mdMessages->save(
			[
				'op_messages'   => $request->get('message'),
				'op_message_title'  => $request->get('title'),
				'op_user_send'  => Session()->get('op_user_id'),
				'op_user_receiver' => $request->get('receiver'),
				'op_sheet_id'   => $request->get('sheetId'),
				'op_sheet_id'   => $request->get('sheetId'),
				'op_datetime'   => date("Y-m-d H:i:s"),
				'op_status'     => 1,
				'op_type'       => 'inbox',
				'op_data_sheet' => $request->get('sheetData'),
				'op_data_sheet_meta' => $request->get('sheetMeta'),
			]
		);

		$userInfo = $this->mdUser->getUserBy('id', $request->get('receiver'));

		$log = 'User <b>' . $this->infoUser['name'] . '</b> send message to User <b>' . $userInfo[0]['user_name'] . '</b>';
		// Set notice success
		$this->mdLogs->add($this->mdLogs->logTemplate( $log, 'Messages'));
	}

	public function shareSheet(Request $request){
		$this->mdSheet->save(
			[
				'sheet_share' => json_encode($request->get('listID')),
			],
			$request->get('sheetId')
		);

		foreach ($request->get('listID') as $userId) {
			$this->mdMessages->save(
				[
					'op_messages'   => 'You have been share with link <a href="'.url('/view-sheet/' . $request->get('sheetId')).'">Here</a>',
					'op_message_title'  => 'Notice System',
					'op_user_send'  => Session()->get('op_user_id'),
					'op_user_receiver' => $userId,
					'op_sheet_id'   => '',
					'op_datetime'   => date("Y-m-d H:i:s"),
					'op_status'     => 1,
					'op_type'       => 'notice',
				]
			);
		}

		echo json_encode([
			'status' => true,
			'socketId' => $request->get('listID')
		]);
	}

}
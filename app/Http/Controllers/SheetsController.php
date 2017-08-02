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

	public function handleSheet( $id = null, $mesId = null ){
		
		registerStyle( [
		    'handsontable' => assets('bower_components/handsontable/handsontable.full.min.css'),
		    'spectrum'     => assets('bower_components/spectrum/spectrum.css'),
		    'samples'     => 'http://handsontable.github.io/handsontable-ruleJS/css/samples.css',
		] ); 

		$sheets = array();

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

			if( empty( $sheets ) ) {
				redirect( url('/error-404?url=' . $_SERVER['REDIRECT_URL']) );
			}
		}

		if( $mesId ) {

			if( 3 == $this->infoUser['meta']['user_role'] ) {
				$checkMes = $this->mdMessages->getBy([
					'op_sheet_id' => $id,
					'op_user_receiver' => $this->infoUser['id'],
					'id' => $mesId,
				]);
				if( empty( $checkMes ) ) {
					redirect( url('/error-404?url=' . $_SERVER['REDIRECT_URL']) );
				}
			}


			$this->mdMessages->save(
				[
					'op_status' => 2
				],
				$mesId
			);

		}

		// Load layout.
		return $this->loadTemplate(
			'sheet/sheet.tpl',
			[
				'infoUser' => $this->infoUser,
				'sheet'  => $sheets,
				'mdUser' => $this->mdUser,
				'mdMessages' => $this->mdMessages
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
		$lastID = $this->mdSheet->save(
			[
				'sheet_title'   => $request->get('sheetTitle'),
				'sheet_description' => $request->get('sheetDescription'),
				'sheet_content' => $request->get('sheetData'),
				'sheet_author'  => Session()->get('op_user_id'),
				'sheet_datetime' => date("Y-m-d H:i:s"),
				'sheet_status'  => 1
			],
			!empty( $request->get('sheetId') )  ? $request->get('sheetId') : null
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


		// foreach ($receiver as $sendID) {
		// 	$this->mdMessages->save(
		// 		[
		// 			'op_sheet_id'  => $lastID,
		// 			'op_messages'  => $request->get('sheetMessage'),
		// 			'op_user_send' => Session()->get('op_user_id'),
		// 			'op_user_receiver' => $sendID,
		// 			'op_datetime'  => date("Y-m-d H:i:s"),
		// 			'op_status'    => 1
		// 		]
		// 	);
		// }

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

}
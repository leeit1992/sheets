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

				if( !empty( $listShare ) && in_array(Session()->get('op_user_id'), $listShare) ) {
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
			'sheet_author' => Session()->get('op_user_id'),
			'sheet_status' => 1
		] );

		$listSheetsOther = $this->mdSheet->getBy( [
			'sheet_author' => Session()->get('op_user_id'),
			'sheet_status' => 3
		] );

		// Load layout.
		return $this->loadTemplate(
			'sheet/sheet.tpl',
			[
				'infoUser' => $this->infoUser,
				'mdSheet' => $this->mdSheet,
				'sheet'  => $sheets,
				'mdUser' => $this->mdUser,
				'mdMessages' => $this->mdMessages,
				'listSheets' => $listSheets,
				'sheetShareStatus' => $sheetShareStatus,
				'listSheetsOther' => $listSheetsOther,
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

		// if( 1 == $this->infoUser['meta']['user_role'] ) {
		// 	$currentDataSheetDecode = json_decode($request->get('sheetData'));
			
		// 	// remove emptry
		// 	foreach ($currentDataSheetDecode as $key => $value) {
		// 		if( empty( $value[1] ) && empty( $value[3] ) ) {
		// 			unset($currentDataSheetDecode[$key]);
		// 		}
		// 	}
			
		// 	$currentDataSheet = json_encode($currentDataSheetDecode, true);

		// }
		

		$lastID = $this->mdSheet->save(
			[
				'sheet_content' => $currentDataSheet,
				'sheet_author'  => $author,
				'sheet_datetime' => date("Y-m-d H:i:s"),
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

	public function transferSheet(Request $request){
		$infoSheet = $this->mdSheet->getBy( 
						[
							'id' => $request->get('sheetId')
						]
					);
		$dataSheetInbox = json_decode($request->get('sheetData'));
		$totalRow = count($dataSheetInbox);

		// Get current sheet data
		if( is_array( json_decode($infoSheet[0]['sheet_content']) ) ) {

			$currentDataSheet = json_decode($infoSheet[0]['sheet_content']);
			// Get row empty
			$listRowEmpty = $this->getRowEmpty($currentDataSheet, $totalRow);

		}else{
			$currentDataSheet = array();
		}

		// Get current sheet meta data
		if( is_array( json_decode($infoSheet[0]['sheet_meta'], true) ) ) {
			$currentMetaSheet = json_decode($infoSheet[0]['sheet_meta'], true);
		}else{
			$currentMetaSheet = array();
		}

		$newMetaSheet = array();
		$dataSheetMetaInbox = json_decode($request->get('sheetMeta'));

		$ccol = 0;
		$crow = 0;
		foreach ($dataSheetMetaInbox as $key => $value) {
			$_crow = 0;
			$_ccol = $ccol;
		
			if( $_crow < $totalRow ) {
				$_crow = $crow += 1;
			}

			if( $crow == $totalRow ) {
				$crow = 0;
				$_ccol = $ccol++;
				
			}

			if( 16 == $ccol) {
				$ccol = 0;
			}

			$newMetaSheet[($_crow-1).'-'.$_ccol] = $value;
		}

		// Merge sheet to meta sheet
		$nextKey = 0;
		$nextRow = count($dataSheetInbox);
		$sheetDataMegeArgs = [];
		foreach ($dataSheetInbox as $key => $value) {

			$_nextRow = $nextRow++;
			$newDataSheetUpdate = [];
			foreach ($value as $_key => $_value) {
				$metaOrder = $nextKey++;
				if( 15 == $metaOrder ) {
					$nextKey = 0;
				}
				
				$newDataSheetUpdate[$metaOrder] = $newMetaSheet[$key . '-' . $metaOrder];
			}

			$sheetDataMegeArgs[] = [
				'data' => $value,
				'meta' => $newDataSheetUpdate
			];
		}

		if( empty( $currentDataSheet ) ) {
			$currentDataSheet = $sheetDataMegeArgs;
		}

		if( !empty( $currentMetaSheet ) ) {
			if( count( $listRowEmpty ) != $totalRow ) {
				$firstValue = array_keys($listRowEmpty);
				unset($listRowEmpty[$firstValue[0]]);
			}	
		}
		
		if( !empty( $currentDataSheet ) ) {
			$iDinbox = 0;
			foreach ($listRowEmpty as $key => $value) {
				$_iDinbox = $iDinbox++;

				$key = $key - 1;
					
				if( $key < 0 ) {
					$key = 0;
				}
			
				$currentDataSheet[$key] = $sheetDataMegeArgs[$_iDinbox];
				
			}
		}

		$newSaveSheetData = [];
		foreach ($currentDataSheet as $row => $value) {

			$data = $value;

			if( isset( $value['data'] ) ) {

				$data  = $value['data'];

				foreach ($value['meta'] as $col => $valueM) {
					$keyMeta = $row . '-' . $col;

					$valueM->rCtm = $valueM->row; // Sheet row of customer
					$valueM->cCtm = $valueM->col; // Sheet col of customer
					$valueM->row = $row;
					$valueM->col = $col;
					// $valueM->background = '';
					$valueM->color = '';
					
					$currentMetaSheet[$keyMeta] = $valueM;


					if( 1 == $this->infoUser['meta']['user_role'] ) {
						$valueM->sIdCtm = $valueM->sheetId; // Sheet id of customer
						$valueM->readOnly = 'false';
					}
					$valueM->readOnly = 'false';

				}
			}

			$newSaveSheetData[$row] = $data;
		}

		$this->mdSheet->save(
				[
					'sheet_content' => json_encode($newSaveSheetData),
				],
				$request->get('sheetId')
			);

		/**
		 * Add meta data for user.
		 */
		$sheetMeta = [
			'sheet_meta' => json_encode($currentMetaSheet),
		];

		// Loop add add | update meta data.
		foreach ($sheetMeta as $mtaKey => $metaValue) {
			$this->mdSheet->setMetaData( $request->get('sheetId'), $mtaKey, $metaValue );
		}

	}

	public function getRowEmpty($currentDataSheet, $totalRow){
		$listRowEmpty = [];
		foreach ($currentDataSheet as $key => $value) {
			if( empty( $value[0] ) && 
				empty( $value[1] ) && 
				empty( $value[2] ) && 
				empty( $value[3] ) ) 
			{	
				if( count($listRowEmpty) < $totalRow ){
					if( empty( $listRowEmpty[$key] ) ) {
						for($i = 0; $i < $totalRow; $i++){
							
							if( null != $currentDataSheet[$key+$i][1] ) {
								$listRowEmpty = [];
							}

							$listRowEmpty[$key + 1 + $i] = $key + 1 + $i;
						}

						if( null != $currentDataSheet[$totalRow + $key][1] ) {
							$listRowEmpty = [];
						}
					}
					
				}
				
			}
		}

		return $listRowEmpty;
	}

	public function addNewSheet(){
		// Load layout.
		return $this->loadTemplate(
			'sheet/addSheet.tpl',
			[
				'listUser' => $this->mdUser->getAll()
			]
		);
	}

	public function handleAddSheet(Request $request){
		if( $request->get('op_user_id') ) {
			foreach ($request->get('op_user_id') as $id) {
				$this->addSheetDefault($id, 
					[
						'sheetTitle' => $request->get('op_sheet_name'),
						'sheetContent' => $this->autoCreatDataSheetEmpty()
					]
				);
			}
		}
	}

	public function addSheetDefault( $uerId, $args ){
		$lastID = $this->mdSheet->save(
			[
				'sheet_title'   => $args['sheetTitle'],
				'sheet_description' => '',
				'sheet_content' => isset( $args['sheetContent'] ) ? json_encode($args['sheetContent']) : '[]',
				'sheet_author'  => $uerId,
				'sheet_datetime' => date("Y-m-d H:i:s"),
				'sheet_status'  => 3
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
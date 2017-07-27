<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;
use Atl\Foundation\Request;
use App\Model\SheetModel;
use App\Model\UserModel;

class SheetsController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->userAccess();

		$this->mdSheet = new SheetModel;
		$this->mdUser = new UserModel;
	}

	public function handleSheet( $id = null ){
		
		registerStyle( [
		    'handsontable' => assets('bower_components/handsontable/handsontable.full.min.css'),
		    'spectrum'     => assets('bower_components/spectrum/spectrum.css'),
		] ); 

		$sheets = array();

		if( $id ) {
			$sheets = $this->mdSheet->getBy( [ 'sheet_author' => Session()->get('op_user_id'), 'id' => $id ] );

			if( empty( $sheets ) ) {
				redirect( url('/error-404?url=' . $_SERVER['REDIRECT_URL']) );
			}
		}

		// Load layout.
		return $this->loadTemplate(
			'sheet/sheet.tpl',
			[
				'sheet' => $sheets
			]
		);
	}

	public function manageSheets(){

		$listSheets = $this->mdSheet->getBy( [ 'sheet_author' => Session()->get('op_user_id') ] );

		// Load layout.
		return $this->loadTemplate(
			'sheet/manageSheets.tpl',
			[
				'listSheets' => $listSheets,
				'mdUser'     => $this->mdUser
			]
		);
	}

	public function saveSheets(Request $request){
		$this->mdSheet->save(
			[
				'sheet_title'   => $request->get('sheetTitle'),
				'sheet_message' => $request->get('sheetMessage'),
				'sheet_content' => $request->get('sheetData'),
				'sheet_author'  => Session()->get('op_user_id'),
				'sheet_datetime' => date("Y-m-d H:i:s")
			]
		);

		// Set notice success
		 $this->mdLogs->add($this->mdLogs->logTemplate( ' Send sheets', 'Sheets'));
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
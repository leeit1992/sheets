<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;
use Atl\Foundation\Request;
use App\Model\SheetModel;

class SheetsController extends baseController{

	public function __construct(){

		$this->mdSheet = new SheetModel;
	}

	public function handleSheet(){
		registerStyle( [
		    'handsontable' => assets('bower_components/handsontable/handsontable.full.min.css'),
		    'spectrum' => assets('bower_components/spectrum/spectrum.css'),
		] ); 
		// Load layout.
		return $this->loadTemplate(
			'sheet/sheet.tpl',
			[
				
			]
		);
	}

	public function manageSheets(){
		// Load layout.
		return $this->loadTemplate(
			'sheet/manageSheets.tpl',
			[
				
			]
		);
	}

	public function saveSheets(Request $request){
		$this->mdSheet->save(
			[
				'sheet_title'   => $request->get('sheetTitle'),
				'sheet_message' => $request->get('sheetMessage'),
				'sheet_content' => $request->get('sheetData'),
			]
		);
	}

}
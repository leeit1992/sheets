<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;

class CanculatorController extends baseController{

	public function canculator(){
		registerStyle( [
		    'handsontable' => assets('bower_components/handsontable/handsontable.full.min.css'),
		    'spectrum' => assets('bower_components/spectrum/spectrum.css'),
		] ); 
		// Load layout.
		return $this->loadTemplate(
			'canculator/canculator.tpl',
			[
				
			]
		);
	}

}
<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;

class MessagesController extends baseController{

	public function manageMessages(){
		// Load layout.
		return $this->loadTemplate(
			'messages/messages.tpl',
			[
				
			]
		);
	}

}
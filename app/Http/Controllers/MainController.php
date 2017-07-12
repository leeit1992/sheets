<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;

class MainController extends baseController{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		
		return $this->loadTemplate(
			'main.tpl',
			[	
				
			]
		);
	}
}
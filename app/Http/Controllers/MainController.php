<?php
namespace App\Http\Controllers;
use Atl\Foundation\Request;

use App\Http\Components\Controller as baseController;

class MainController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->userAccess();
	}

	public function index(){
		
		return $this->loadTemplate(
			'main.tpl',
			[	
				
			]
		);
	}

	/**
	 * Handle set page 404
	 */
	public function page404(Request $request){
		return View(
			'error404.tpl',
			[	
				'url' => $request->get('url'),
				'redirect' => url('/')
			]
		);
	}
}
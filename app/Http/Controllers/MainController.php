<?php
namespace App\Http\Controllers;
use Atl\Foundation\Request;
use App\Model\MessagesModel;
use App\Http\Components\Controller as baseController;

class MainController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->userAccess();

		$this->mdMessages = new MessagesModel;
	}

	public function index(){
		
		$inbox = $this->mdMessages->getBy( [ 'op_type' => 'inbox', 'op_status' => 1, 'op_user_receiver'  => Session()->get('op_user_id') ] );
		$notice = $this->mdMessages->getBy( [ 'op_type' => 'notice', 'op_status' => 1, 'op_user_receiver'  => Session()->get('op_user_id') ] );
		
		return $this->loadTemplate(
			'main.tpl',
			[	
				'inbox' => $inbox,
				'notice' => $notice,
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
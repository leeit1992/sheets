<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;
use App\Model\LogsModel;
use Atl\Pagination\Pagination;
use App\Model\UserModel;
use Atl\Foundation\Request;

class LogsController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->userAccess();
		$this->userRole();

		// Model data system.
		$this->mdLogs = new LogsModel;
		$this->mdUser = new UserModel;
	}

	public function manageLogs( $page = null ){

		$ofset                = 10;
        $config['pageStart']  = $page;
        $config['ofset']      = $ofset;
        $config['totalRow']   = $this->mdLogs->count();
        $config['baseUrl']    = url('/logs/page/');
        $config['classes']    = 'uk-pagination uk-margin-medium-top';
        $config['nextLink']   = '<i class="uk-icon-angle-double-right"></i>';
        $config['prevLink']   = '<i class="uk-icon-angle-double-left"></i>';
        $config['tagOpenPageCurrent']   = '<li class="uk-active"><span>';
        $config['tagClosePageCurrent']  = '<span></li>';
        $config['tagOpen']  = '';
        $config['tagClose'] = '';

        $pagination           = new Pagination($config);

		return $this->loadTemplate(
			'log/manageLog.tpl',
			[	
				'listLogs'   => $this->mdLogs->getLogsLimit( $pagination->getStartResult( $page ), $ofset ),
				'pagination' => $pagination->link(),
				'mdUser'     => $this->mdUser
			]
		);
	}

	public function filterLogs(Request $request){
		$output = array();
		switch ($request->get('type')) {
			case 'user':
				$output = $this->mdLogs->getBy(['user_id' => $request->get('key')]);
			break;
			case 'date':
				$output = $this->mdLogs->getBy(['log_datetime[~]' => date( 'Y-m-d', strtotime( $request->get('key') ) )]);
			break;
		}

		echo json_encode(['data' => $output]);
	}

	public function removeLogs(Request $request){
		$this->mdLogs->delete($request->get('id'));
	}

	public function clearLogs(Request $request){
		$this->mdLogs->clearLog();

	}
}
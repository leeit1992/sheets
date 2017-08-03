<?php
namespace App\Http\Controllers;

use App\Http\Components\Controller as baseController;
use Atl\Foundation\Request;
use App\Model\MessagesModel;
use App\Model\UserModel;
use App\Model\SheetModel;

class MessagesController extends baseController{

	public function __construct(){
		parent::__construct();
		$this->userAccess();

		$this->mdMessages = new MessagesModel;
		$this->mdUser = new UserModel;
		$this->mdSheet = new SheetModel;
	}

	public function messageSend(){
		$condition['op_user_send'] = Session()->get('op_user_id');
		$condition['op_type']      = 'send';
		$condition['ORDER'] = [
						'id' => 'DESC'
					];

		$listMessages = $this->mdMessages->getBy( 
			$condition
		);
		return $this->loadTemplate(
			'messages/messageSend.tpl',
			[
				'listMessages' => $listMessages,
				'mdUser'  => $this->mdUser,
				'listSheets' => $this->mdSheet->getBy(['sheet_author' => Session()->get('op_user_id')]),
				'userCurrent' => $this->infoUser
			]
		);
	}

	public function writeMessages(Request $request){

		if(  $request->Get('formData') ) {
			parse_str($request->get('formData'), $formData);
			if ( !empty( $formData['op_sheet'] ) ) {
				$this->mdSheet->save(
					[
						'sheet_status'  => 2
					],
					$formData['op_sheet']
				);
			}
			$this->mdMessages->save(
				[
					'op_sheet_id'  => $formData['op_sheet'],
					'op_messages'  => $formData['op_messages'],
					'op_message_title'  => $formData['op_title'],
					'op_user_send' => Session()->get('op_user_id'),
					'op_user_receiver' => $formData['op_receiver'],
					'op_datetime'  => date("Y-m-d H:i:s"),
					'op_status'    => 1,
					'op_type'      => 'send'
				]
			);

			$this->mdMessages->save(
				[
					'op_sheet_id'  => $formData['op_sheet'],
					'op_messages'  => $formData['op_messages'],
					'op_message_title'  => $formData['op_title'],
					'op_user_send' => Session()->get('op_user_id'),
					'op_user_receiver' => $formData['op_receiver'],
					'op_datetime'  => date("Y-m-d H:i:s"),
					'op_status'    => 1,
					'op_type'      => 'inbox'
				]
			);
	
			$userInfo = $this->mdUser->getUserBy('id',$formData['op_receiver']);

			$log = 'User <b>' . $this->infoUser['name'] . '</b> send message to User <b>' . $userInfo[0]['user_name'] . '</b>';
			// Set notice success
			$this->mdLogs->add($this->mdLogs->logTemplate( $log, 'Messages'));
		}

	}

	public function manageMessages(){

		$condition['op_user_receiver'] = Session()->get('op_user_id');
		$condition['op_type'] = 'inbox';
		$condition['ORDER'] = [
						'id' => 'DESC'
					];

		$listMessages = $this->mdMessages->getBy( 
			$condition
		);

		$listSheets = $this->mdSheet->getBy(['sheet_author' => Session()->get('op_user_id')]);

		if( 1 == $this->infoUser['meta']['user_role'] ) {
			$listSheets = $this->mdSheet->getBy();
		}

		if( 3 == $this->infoUser['meta']['user_role'] ) {
			$mesIds = array();
			foreach ($listMessages as $key => $value) {
				$mesIds[] = $value['op_sheet_id'];
			}

			$listSheets = $this->mdSheet->getBy(
				["OR" => [
					'sheet_author' => Session()->get('op_user_id'),
					'id' => $mesIds,
				]]
			);
		}

		// Load layout.
		return $this->loadTemplate(
			'messages/inbox.tpl',
			[
				'listMessages' => $listMessages,
				'mdUser'  => $this->mdUser,
				'listSheets' => $listSheets,
				'userCurrent' => $this->infoUser
			]
		);
	}

	public function removeMessages(Request $request){
		if( 'send' == $request->get('type') ) {
			$check = $this->mdMessages->getBy( 
				[
					'op_user_send' => Session()->get('op_user_id'),
					'op_type' => 'send'
				]
			);

			if( !empty( $check ) ) {
				$this->mdMessages->delete($request->get('id'));
			}
		}
		if( 'inbox' == $request->get('type') ) {
			$check = $this->mdMessages->getBy( 
				[
					'op_user_receiver' => Session()->get('op_user_id'),
					'op_type' => 'inbox'
				]
			);
			
			if( !empty( $check ) ) {
				$this->mdMessages->delete($request->get('id'));
			}
		}
	}

	public function filterMessages(Request $request){

		$output = '';
		switch ($request->get('type')) {
			case 'search':
				$condition['op_message_title[~]'] = $request->get('value');
				$condition['op_type'] = $request->get('typeMes');
				$condition['ORDER'] = [
							'id' => 'DESC'
					];
				$listMessages = $this->mdMessages->getBy( 
					$condition
				);
				
				ob_start();
				View(
					'messages/layout/listMesJs.tpl',
					[
						'listMessages' => $listMessages,
						'mdUser'  => $this->mdUser,
						'typeMes' => $request->get('typeMes')
					]
				);
				$output .= ob_get_clean();
			break;

			case 'filter-user':

				if( 'inbox' == $request->get('typeMes') ) {
					$condition['op_user_send'] = $request->get('value');
				}else{
					$condition['op_user_receiver'] = $request->get('value');
				}

				$condition['op_type'] = $request->get('typeMes');
				$condition['ORDER'] = [
							'id' => 'DESC'
					];

				$listMessages = $this->mdMessages->getBy( 
					$condition
				);
				
				ob_start();
				View(
					'messages/layout/listMesJs.tpl',
					[
						'listMessages' => $listMessages,
						'mdUser'  => $this->mdUser,
						'typeMes' => $request->get('typeMes')
					]
				);
				$output .= ob_get_clean();
			break;

			case 'filter-date':

				$condition['op_datetime[~]'] = date( 'Y-m-d', strtotime( $request->get('value') ) );
				$condition['op_type'] = $request->get('typeMes');
				$condition['ORDER'] = [
							'id' => 'DESC'
					];
				$listMessages = $this->mdMessages->getBy( 
					$condition
				);
				
				ob_start();
				View(
					'messages/layout/listMesJs.tpl',
					[
						'listMessages' => $listMessages,
						'mdUser'  => $this->mdUser,
						'typeMes' => $request->get('typeMes')
					]
				);
				$output .= ob_get_clean();
			break;
			
		}

		echo json_encode([
			'data' => $output
		]);
	}

	public function updateInbox(Request $request){
		$this->mdMessages->save(
			[
				'op_status'    => 2,
			], $request->get('id')
		);
	}

}
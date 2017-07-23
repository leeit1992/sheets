<?php

namespace App\Model;

use Atl\Database\Model;

class LogsModel extends Model
{	

	public function __construct(){
		parent::__construct('logs');
	}

	/**
	 * Insert log to system.
	 * 
	 * @param  array  $log Log content.
	 * @return int
	 */
	public function add( $log ){

		$this->db->insert(
				$this->table, 
				[
					'user_id' => Session()->get('atl_user_id'),
					'logs'    => $log
				]
			);

		return $this->db->id();
	}

	/**
	 * Handle get limit log
	 * 
	 * @param  int 	  	$start Start query.
	 * @param  int 		$limit Number of row result.
	 * @return array
	 */
	public function getLogsLimit( $start, $limit ){
		return $this->db->select(
			$this->table, 
				'*', 
				[
					'LIMIT' => [$start, $limit],
					"ORDER" => [
						'id' => 'DESC'
					]
				]
			);
	}

	public function count( $condition = [] ){
		return $this->db->count($this->table, $condition);
	}

	public function logTemplate( $log, $module ){
		$userId   = Session()->get('op_user_id');
		$userName = Session()->get('op_user_name');
		return  '<b>User ID: ' . $userId . '</b> with the name is ( <b>' . ucfirst( $userName )  . '</b> ) has ' .  $log 
		. ' at the module ' . $module . '.<br/>' .$_SERVER['HTTP_USER_AGENT'] . '<br/> <b>At Time</b>: ' . date("Y-m-d H:i:s");
	}
}
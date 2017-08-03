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
					'user_id' => Session()->get('op_user_id'),
					'logs'    => $log,
					'log_datetime' => date("Y-m-d H:i:s")
				]
			);

		return $this->db->id();
	}

	/**
	 * Handle query get by column.
	 * 
	 * @param  string|array $key   Column key
	 * @param  string $value Condition query
	 * @return array
	 */
	public function getBy( $key, $value = null ){

		if( is_array( $key ) ) {
			$where = $key;
		}else{
			$where = [ $key => $value ];
		}

		return $this->db->select(
			$this->table, 
				'*', 
				$where
			);
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

	/**
	 * Handle remove
	 * 
	 * @param  int | array $args Data id
	 * @return void
	 */
	public function delete( $args ){
		return $this->db->delete(
			$this->table,
			[
			"AND" => [
				"id" => $args,
			]
		]);
	}

	public function clearLog(){
		$data = $this->db->query('truncate op_'.$this->table);
	}
}
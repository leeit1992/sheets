<?php 
namespace App\Model;

use Atl\Database\Model;
use App\Model\AtlModel;

class SheetModel extends AtlModel
{
	public function __construct(){
		parent::__construct('sheets');
	}

	/**
	 * Sett meta table.
	 * 
	 * @return string
	 */
	public function metaDataTable(){
		return 'sheetmeta';
	}

	/**
	 * Set meta query.
	 * 
	 * @return stirng
	 */
	public function metaDataQueryBy(){
		return 'sheet_id';
	}

	/**
	 * Insert | Update data car.
	 * 
	 * @param  array  $argsData Array data insert | update
	 * @param  int    $id       Car id
	 * @return array
	 */
	public function save( $argsData, $id = null ){

		if( $id ){
			$this->db->update(
				$this->table, 
				$argsData,
				[ 'id' => $id ]
			);
			return $id;
		}else{
			$this->db->insert(
				$this->table, 
				$argsData
			);

			return $this->db->id();
		}
	}


	/**
	 * Handle query get by column.
	 * 
	 * @param  string|array $key   Column key
	 * @param  string $value Condition query
	 * @return array
	 */
	public function getBy( $key = null, $value = null ){
		
		$where = [];

		if( is_array( $key ) ) {
			$where = $key;
		}else{
			if( $key ){
				$where = [ $key => $value ];
			}
		}

		$listSheets = $this->db->select(
			$this->table, 
				'*', 
				$where
			);

		$args = array();
		foreach ($listSheets as $sheet) {
			$metas = $this->getAllMetaData( $sheet['id'] );
			
			if( !empty( $metas ) ) {
				foreach ($metas as $mkey => $mValue) {
					$sheet[$mkey] = $mValue;
				}
			}
			
			$args[] = $sheet;
			
		}

		return $args;
	}


	/**
	 * Handle count Car
	 * @return array
	 */
	public function count(){
		return $this->db->count($this->table,
								[
									'service_type' => 'car',
								]
								);
	}


	/**
	 * Handle remove car
	 * 
	 * @param  int | array $args Data id car
	 * @return void
	 */
	public function delete( $args ){
		return $this->db->delete(
			$this->table,
			[
			"AND" => [
				"id" => $args
			]
		]);
	}

	public function deleteByAuthor( $id ){
		$listSheet = $this->getBy('sheet_author', $id);
		foreach ($listSheet as $value) {
			$this->deleteMetaData( $value['id'] );
		}
		
		return $this->db->delete(
			$this->table,
			[
			"AND" => [
				"sheet_author" => $id
			]
		]);
	}

	/**
	 * Handle search by key
	 * 
	 * @param  string $key  Key search value.
	 * @return void
	 */
	public function searchBy( $key ){
		$listCar =  $this->db->select(
			$this->table,
			'*',
			[
				"service_type" => 'car',
				"service_name[~]" => $key
			]
		);
		$argsCars = [];
		foreach ($listCar as $car) {
			$carMeta = $this->getAllMetaData( $car['id'] );
			$argsCars[] = $this->setListCars($carMeta,$car);
		}
		return $argsCars;
	}

}
?>
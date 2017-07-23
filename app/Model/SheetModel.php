<?php 
namespace App\Model;

use Atl\Database\Model;

class SheetModel extends Model
{
	public function __construct(){
		parent::__construct('sheets');
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
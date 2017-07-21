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
	 * Handle query get info car by key.
	 * 
	 * @param  stirng $key   Column key
	 * @return array
	 */
	public function getinfoCar( $id ){
		$infoCar = array();
		$car = $this->db->select(
			$this->table, 
				'*', 
				[
					'id' => $id,
				]
			);
		$car[] = $this->getAllMetaData( $id );
		foreach ($car as $items) {
			foreach ($items as $key => $value) {
				$infoCar[$key] = $value;
			}
		}
		return $infoCar;
	}

	/**
	 * Handle get limit car
	 * @param  int 	  	$start Start query.
	 * @param  int 		$limit Number of row result.
	 * @return array
	 */
	public function getCarLimit( $start, $limit ){
		return $this->db->select(
			$this->table, 
				'*', 
				[	
					'service_type' => 'car',
					'LIMIT' => [$start, $limit],
				]
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
	 * Handle get all car by meta key and meta value.
	 * 
	 * @param  string $metakey   Meta key of car.
	 * @param  string $metaValue Meta value of car.
	 * @return array
	 */
	public function getAllCarByMeta( $metakey, $metaValue = null ){
		$listCar = $this->db->select(
			$this->table, 
				'*',
				[
					'service_type' => 'car'
				]
			);
		$argsCars = array();
		foreach ($listCar as $car) {
			$carMeta = $this->getAllMetaData( $car['id'] );
			if( $metaValue ) {
				if( $carMeta[$metakey] === $metaValue ) {
					$argsCars[] = $this->setListCars($carMeta,$car);
				}
			}else{
				$argsCars[] = $this->setListCars($carMeta,$car);
			}
		}
		return $argsCars;
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

	/**
	 * List type car.
	 * 
	 * @param  int 		$typeKey Level of type
	 * @return string | array 
	 */
	public function getTypeCar(){
		$types = [
			'10' => '4-10 seats',
			'20' => '11-20 seats',
			'30' => '21-30 seats',
			'40' => '31-40 seats',
			'50' => '> 41 seats',
		];
		return $types;
	}
	/**
	 * Handle get all car by seats.
	 * 
	 * @param  string $typeStatus type seats 
	 * @return array
	 */
	public function getAllCarBySeat($typeStatus){
		$listCar = $this->db->select(
			$this->table, 
				'*',
				[
					'service_type' => 'car'
				]
			);
		$argsCars = array();
		foreach ($listCar as $car) {
			$carMeta = $this->getAllMetaData( $car['id'] );
			switch ($typeStatus) {
				case '10':
					if ($carMeta['car_seats'] > 0 &&$carMeta['car_seats'] < 11) {
						$argsCars[] = $this->setListCars($carMeta,$car);
					}
					break;
				case '20':
					if ($carMeta['car_seats'] > 10 &&$carMeta['car_seats'] < 21) {
						$argsCars[] = $this->setListCars($carMeta,$car);
					}
					break;
				case '30':
					if ($carMeta['car_seats'] > 20 &&$carMeta['car_seats'] < 31) {
						$argsCars[] = $this->setListCars($carMeta,$car);
					}
					break;
				case '40':
					if ($carMeta['car_seats'] > 30 &&$carMeta['car_seats'] < 41) {
						$argsCars[] = $this->setListCars($carMeta,$car);
					}
					break;
				case '50':
					if ($carMeta['car_seats'] > 40) {
						$argsCars[] = $this->setListCars($carMeta,$car);
					}
					break;
				default:
					$argsCars[] = $this->setListCars($carMeta,$car);
					break;
			}
		}
		return $argsCars;
	}
	/**
	 * Handle set all car
	 * @param  array $carMeta list meta car
	 * @param  array $car
	 * @return array   
	 */
	private function setListCars( $carMeta , $car){
		foreach ($carMeta as $cMkey => $cMValue) {
			$car[$cMkey] = $cMValue;
		}
		return $argsCars[] = $car;
	}
}
?>
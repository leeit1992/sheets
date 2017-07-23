<?php

namespace App\Model;

use Atl\Database\Model;

abstract class AtlModel extends Model
{

	/**
	 * Condition query meta data
	 * 
	 * @var string | Array
	 */
	protected $metaDataQueryBy;

	/**
	 * MetaData table.
	 * @var string | Array
	 */
	protected $metaDataTable;

	public function __construct( $table ){
		parent::__construct( $table );

		$this->metaDataQueryBy = $this->metaDataQueryBy();
		$this->metaDataTable   = $this->metaDataTable();
	}

	abstract function metaDataTable();

	abstract function metaDataQueryBy();

	/**
	 * Set value for meta data.
	 * 
	 * @param int $id         	 Query by id.
	 * @param string $metaKey    Meta key
	 * @param string|array 		 Meta value.
	 */
	public function setMetaData( $id, $metaKey, $meta_value ){

		$checkMeta = $this->getMetaData( $id, $metaKey, true );

		if( is_array( $meta_value ) ) {
			$meta_value = json_encode( $meta_value );
		}

		if( empty( $checkMeta ) ) {
			$this->db->insert(
				$this->metaDataTable,
				[
					"meta_key"   => $metaKey,
					"meta_value" => $meta_value,
					$this->metaDataQueryBy => $id
				]
			);
		}else{
			$this->db->update(
				$this->metaDataTable,
				["meta_value" => $meta_value],
				[
					"meta_key" => $metaKey,
					$this->metaDataQueryBy => $id
				]
			);
		}
	}

	/**
	 * Get meta data by key and id
	 * 
	 * @param  int    $id      Id of object use meta data.
	 * @param  string $metaKey Meta key condition query
	 * @return array
	 */
	public function getMetaData( $id, $metaKey, $checkKey = false ){
		$data = $this->db->select(
			$this->metaDataTable, 
				["meta_key", "meta_value"], 
				[
					'meta_key' => $metaKey,
					$this->metaDataQueryBy => $id
				]
			);

		if( $checkKey ) {
			if( !isset( $data[0]['meta_key'] ) ) {
				return null;
			}else{
				return $data[0]['meta_key'];
			}
		}

		if( empty( $data ) ) {
			return null;
		}

		return $data[0]['meta_value'];
	}

	public function getAllMetaData( $id ){
		$data = $this->db->select(
			$this->metaDataTable, 
				["meta_key", "meta_value"], 
				[
					$this->metaDataQueryBy => $id
				]
			);

		if( empty( $data ) ) {
			return null;
		}

		$newArgs = array();
		foreach ($data as $meta) {
			$newArgs[$meta['meta_key']] = $meta['meta_value'];
		}

		return $newArgs;
	}
	/**
	 * Handle remove meta data
	 * 
	 * @param  int | array $args Data id user
	 * @return void
	 */
	public function deleteMetaData($args){
		return $this->db->delete(
			$this->metaDataTable,
				[
					"AND" => [
						$this->metaDataQueryBy => $args
					] 
				]
			);
	}

	/**
	 * Handle get all meta and merge meta for table primary.
	 * 
	 * @param  array $listData List data from table primary.
	 * @return array
	 */
	public function getAllMetaDataBy( $listData ){

		$argsNew = array();
		foreach ($listData as $data) {
			$meta = $this->getAllMetaData( $data['id'] );
			
			if( !empty( $meta ) ) {
				foreach ($meta as $uMkey => $uMValue) {
					$data[$uMkey] = $uMValue;
				}
			}
		
			$argsNew[] = $data;
		}
		return $argsNew;
	}

}
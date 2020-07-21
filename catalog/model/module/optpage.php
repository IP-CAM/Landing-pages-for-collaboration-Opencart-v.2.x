<?php
class ModelModuleOptpage extends Model {
	
	public function getPageData($page_id) {
		
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'optpage_id=" . $page_id . "') AS keyword FROM " . DB_PREFIX . "opt WHERE id = '" . $page_id . "'");
		
		if (isset($query->rows[0])) {
			return $query->rows[0];
		}		
	}

	public function getManufacturerName($manufacturer_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id='". $manufacturer_id ."'");
		if($query->rows[0]['name']) {
			return $query->rows[0]['name'];
		}
	}

	public function getCategoryName($category_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id='". $category_id ."'");
		if($query->rows[0]['name']) {
			return $query->rows[0]['name'];
		}
	}

	public function getAllOptPage() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "opt");
		return $query->rows;
	}

}
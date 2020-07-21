<?php
class ModelCatalogOpt extends Model {

	// Получаем список посадочных на страницу
	public function getOptList($data = array()){

		// $type = $data['type'];
		$sql = "SELECT opt.id, opt.type, cd.name as cname, md.name as mname, opt.meta_title as title, opt.meta_description, opt.meta_keywords as keywords, opt.h1, opt.description FROM " . DB_PREFIX . "opt opt LEFT JOIN " . DB_PREFIX . "category_description cd ON(opt.category_id = cd.category_id AND cd.language_id = ". (int)$this->config->get('config_language_id') . " ) LEFT JOIN oc_manufacturer md ON(opt.manufacturer_id = md.manufacturer_id) WHERE 1";

		if (isset($data['filter_type']) && !is_null($data['filter_type'])) {
			$sql .= " AND type = '" . $data['filter_type'] . "'";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		

		// var_dump($data['filter_type']);

		$query = $this->db->query($sql);
		return $query->rows;
	}

	// Счетчик посадочных страниц
	public function getOptTotal($data = array()) {
		// $type = $data['type'];
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "opt WHERE 1";
		
		if (isset($data['filter_type']) && !is_null($data['filter_type'])) {
			$sql .= " AND type = '" . $data['filter_type'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	// Получаем данные страницы с ID %
	public function getOptPageData($page_id){
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'optpage_id=" . $page_id . "') AS keyword FROM " . DB_PREFIX . "opt WHERE id = '" . $page_id . "'");
		return $query->rows[0];
	}

	public function getAllCategories(){		
		$result = array();
		
		$q = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) ORDER BY c.parent_id, c.sort_order, cd.name");
		
		foreach ($q->rows as $row) {
			$result[$row['category_id']]['category_id'] = $row['category_id'];
			$parent = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = " . $row['parent_id']);
			if (isset($parent->rows[0]['name'])){
				$result[$row['category_id']]['name'] = $parent->rows[0]['name'] . ' — ' . $row['name'];
			} else{
				$result[$row['category_id']]['name'] = $row['name'];
			}
		}
		
		return $result;
	}

	public function getAllManufacturers(){
		$q = $this->db->query("SELECT manufacturer_id, name FROM " . DB_PREFIX . "manufacturer WHERE 1");
		return $q->rows;
	}

	public function savePage($data){

		if(!empty($data['page_id'])) {

			$this->db->query("UPDATE `" . DB_PREFIX . "opt` SET category_id = '". $data['category_id'] ."', manufacturer_id = '". $data['manufacturer_id'] ."', meta_title = '". $data['title'] ."', h1 = '". $data['h1'] ."', meta_keywords = '". $data['meta_keywords'] ."', meta_description = '". $data['meta_description'] ."', description = '". $data['description'] ."', type = '". $data['type'] ."' WHERE id = '" . (int)$data['page_id'] . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'optpage_id=" . (int)$data['page_id'] . "'");

			if ($data['keyword']) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'optpage_id=" . (int)$data['page_id'] . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}

		} else {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "opt` SET category_id = '". $data['category_id'] ."', manufacturer_id = '". $data['manufacturer_id'] ."', meta_title = '". $data['title'] ."', h1 = '". $data['h1'] ."', meta_keywords = '". $data['meta_keywords'] ."', meta_description = '". $data['meta_description'] ."', description = '". $data['description'] ."', type = '". $data['type'] ."' ");

			if ($data['keyword']) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = CONCAT('optpage_id=', LAST_INSERT_ID()), keyword = '" . $this->db->escape($data['keyword']) . "'");
			}

		}


		

		// $this->db->query("DELETE FROM `" . DB_PREFIX . "opt` WHERE category_id = '" . (int)$data['category_id'] . "'");
		
		// $this->db->query("INSERT INTO `" . DB_PREFIX . "opt` SET category_id = '" . (int)$data['category_id'] . "', title = '" . $data['title'] . "', keyword = '" . $data['keyword'] . "', meta_description = '" . $data['meta_description']  . "', h1 = '" . $data['h1']  . "', description = '" . $data['description'] . "'");
	}

	public function deleteOptPage($page_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "opt WHERE id = '" . (int)$page_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'optpage_id=" . (int)$page_id . "'");
	}

}
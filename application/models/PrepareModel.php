<?php 
class PrepareModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	public function loadData($tb) {
		return $this->db->get($tb)->result_array();
	}
	public function loadDataid($tb, $fd, $vl) {
		$this->db->where($fd, $vl);
		return $this->db->get($tb)->result_array();
	}
	public function insertData($tb, $ar) {
		$this->db->insert($tb, $ar);
		return $this->db->insert_id();
	}

	public function updateData($tb, $fd, $vl, $ar){
		$this->db->where($fd, $vl);
		$this->db->update($tb, $ar);
	}

	public function deleteData($tb, $fd, $vl) {
		$this->db->where($fd, $vl);
		$this->db->delete($tb);
	}
}
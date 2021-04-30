<?php 
class IndexModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function loadUser($u_user) {
		$this->db->where('u_user', $u_user);
		return $this->db->get('user')->result_array();
	}

	public function checkAdmin($u_id) {
		$this->db->join('admin AS a', 'u.u_id = a.u_id');
		return $this->db->get('user as u')->result_array();
	}

	public function checkMarket($u_id) {
		$this->db->join('market AS m', 'u.u_id = m.u_id');
		$this->db->where('u.u_id', $u_id);
		return $this->db->get('user as u')->result_array();
	}

	public function checkCustomer($u_id) {
		$this->db->join('customer AS c', 'u.u_id = c.u_id');
		$this->db->where('u.u_id', $u_id);
		return $this->db->get('user as u')->result_array();
	}
	
}
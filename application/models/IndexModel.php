<?php 
class IndexModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function loadMarker() {
		$this->db->select('m_id, m_name, m_shoptype, m_lat, m_lng, m_img, m_shopdetail');
		return $this->db->get('market')->result_array();
	}

	public function goods($id){
		$this->db->where('m_id', $id);
		$this->db->where('g_level', 0);
		return $this->db->get('goods')->result_array();
	}

	public function Rgoods($id){
		$this->db->where('m_id', $id);
		$this->db->where('g_level', 1);
		return $this->db->get('goods')->result_array();
	}

	public function report($id){
        $this->db->select('c.c_name, c.c_lname, c.c_img, r.r_comment');
		$this->db->join('customer AS c', 'c.c_id = r.c_id');
		$this->db->where('m_id', $id);
		return $this->db->get('report AS r')->result_array();
	}

	public function loadmarketid($id) {
		$this->db->where('m_id', $id);
		return $this->db->get('market')->result_array();
	}

	public function loadDataMarker($type) {
		$this->db->where('m_shoptype', $type);
		$this->db->select('m_id, m_name, m_shoptype, m_lat, m_lng, m_img, m_shopdetail');
		return $this->db->get('market')->result_array();
	}

	public function loadDataMarkerSearch($data) {
		$this->db->select('g.g_name, m.m_shopname, m.m_lng, m.m_lat');
		$this->db->join('market AS m', 'm.m_id = g.m_id');
		$this->db->like('g.g_name', $data);
		return $this->db->get('goods AS g')->result_array();
	}	
	
	//login
	public function loadUser($tb, $fdUser, $vlUser, $fdPass, $vlPass) {
		$this->db->where($fdUser, $vlUser);
		$this->db->where($fdPass, $vlPass);
		return $this->db->get($tb)->result_array();
	}

	//register
	public function loadCUser($c_user) {
		$this->db->where('c_user', $c_user);
		return $this->db->get('customer')->result_array();
	}

	public function loadMUser($m_user) {
		$this->db->where('m_user', $m_user);
		return $this->db->get('market')->result_array();
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

	//add register to database
	public function addRegister($tb, $vl) {
		$this->db->insert($tb, $vl);
	}
	
}
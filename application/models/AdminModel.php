<?php 
class AdminModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	//login
	public function loadUser($tb, $fdUser, $vlUser, $fdPass, $vlPass) {
		$this->db->where($fdUser, $vlUser);
		$this->db->where($fdPass, $vlPass);
		return $this->db->get($tb)->result_array();
	}

	//Market

	public function loadmarket() {
		$this->db->select('m_id, m_name, m_lname, m_shopname, m_shoptype');
        return $this->db->get('market')->result_array();
	}

	public function loadmarketsearch($data) {
		$this->db->select('m_id, m_name, m_lname, m_shopname, m_shoptype');
		$this->db->like('m_shopname', $data);
		return $this->db->get('market')->result_array();
	}

	public function marketdetail($id){
		$this->db->where('m_id', $id);
		return $this->db->get('market')->result_array();
	}

	public function loadmarketimguser($id){
		$this->db->where('m_id', $id);
		$this->db->select('m_user, m_img');
		return $this->db->get('market')->result_array();
	}

	public function goods($id){
		$this->db->where('m_id', $id);
		return $this->db->get('goods')->result_array();
	}

	public function report($id){
        $this->db->select('c.c_name, c.c_lname, c.c_img, r.r_comment');
		$this->db->join('customer AS c', 'c.c_id = r.c_id');
		$this->db->where('m_id', $id);
		return $this->db->get('report AS r')->result_array();
	}

	public function loadgoodsimg($id){
		$this->db->where('g_id', $id);
		$this->db->select('g_img');
		return $this->db->get('goods')->result_array();
	}

	public function deletegoods($g_id){
		$this->db->where('g_id', $g_id);
		return $this->db->delete('goods');
	}

	//Customer

	public function loadcustomer() {
		$this->db->select('c_id, c_name, c_lname');
        return $this->db->get('customer')->result_array();
	}

	public function loadcustomersearch($data) {
		$this->db->select('c_id, c_name, c_lname');
		$this->db->like('c_name', $data);
		$this->db->or_like('c_lname', $data);
		return $this->db->get('customer')->result_array();
	}

	public function customerdetail($id) {
		$this->db->where('c_id', $id);
        return $this->db->get('customer')->result_array();
	}

	public function scoredetail($id) {
		$this->db->join('market AS m', 'm.m_id = s.m_id');
		$this->db->join('customer AS c', 'c.c_id = s.c_id');
		$this->db->where('c.c_id', $id);
        return $this->db->get('score AS s')->result_array();
	}

	public function customeredit($id) {
		$this->db->where('c_id', $id);
        return $this->db->get('customer')->result_array();
	}

	public function loadcimg($id) {
        $this->db->where('c_id', $id);
        $this->db->select('c_img');
        return $this->db->get('customer')->result_array();
    }

	//Promotion

	public function loadpromotion() {
		$this->db->join('market AS m', 'm.m_id = p.m_id');
		$this->db->join('goods AS g', 'g.g_id = p.g_id');
        return $this->db->get('promotion AS p')->result_array();
	}
	
}
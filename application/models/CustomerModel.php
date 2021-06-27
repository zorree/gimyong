<?php 
class CustomerModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	//Market

	public function loadcustomer() {
		$this->db->where('u_id', $this->session->userdata('id'));
        return $this->db->get('customer')->result_array();
    }

    public function loadmarket() {
		$this->db->select('m_id, m_name, m_lname, m_shopname, m_shoptype');
        return $this->db->get('market')->result_array();
    }

	public function loadmarketsearch($data) {
		$this->db->select('m_id, m_name, m_lname, m_shopname, m_shoptype');
		$this->db->like('m_shopname', $data);
		return $this->db->get('market')->result_array();
	}

	public function loadcimg() {
        $this->db->where('c_id', $this->session->userdata('id'));
        $this->db->select('c_img');
        return $this->db->get('customer')->result_array();
    }
    
    public function customerdetail() {
		$this->db->where('c_id', $this->session->userdata('id'));
        return $this->db->get('customer')->result_array();
	}

	public function scoredetail() {
		$this->db->join('market AS m', 'm.m_id = s.m_id');
		$this->db->join('customer AS c', 'c.c_id = s.c_id');
		$this->db->where('c.c_id', $this->session->userdata('id'));
        return $this->db->get('score AS s')->result_array();
	}

	public function marketdetail($id){
		$this->db->where('m_id', $id);
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

	public function loadreport(){
		$this->db->select('m.m_shopname, m.m_img, r.r_comment, r.r_id');
		$this->db->join('market AS m', 'm.m_id = r.m_id');
		$this->db->where('r.c_id', $this->session->userdata('id'));
		return $this->db->get('report AS r')->result_array();
	}

	public function showreport($id){
		$this->db->select('m.m_shopname, r.r_comment, r.r_id');
		$this->db->join('market AS m', 'm.m_id = r.m_id');
		$this->db->where('r.r_id', $id);
		return $this->db->get('report AS r')->result_array();
	}

	//Customer
	public function customeredit($id) {
		$this->db->where('c_id', $id);
        return $this->db->get('customer')->result_array();
	}

	//Promotion
	public function loadpromotion() {
		$this->db->join('market AS m', 'm.m_id = p.m_id');
		$this->db->join('goods AS g', 'g.g_id = p.g_id');
        return $this->db->get('promotion AS p')->result_array();
	}

}
<?php 
class MarketModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function loadmarket() {
		$this->db->where('m_id', $this->session->userdata('id'));
		return $this->db->get('market')->result_array();
	}

	public function loadmarketimg() {
		$this->db->where('m_id', $this->session->userdata('id'));
		$this->db->select('m_img');
		return $this->db->get('market')->result_array();
	}

	public function loadgoods(){
		$this->db->where('m_id', $this->session->userdata('id'));
		$this->db->where('g_level', 0);
		return $this->db->get('goods')->result_array();
	}

	public function loadRgoods(){
		$this->db->where('m_id', $this->session->userdata('id'));
		$this->db->where('g_level', 1);
		return $this->db->get('goods')->result_array();
	}

	public function loadreport(){
		$this->db->select('c.c_name, c.c_lname, c.c_img, r.r_comment');
		$this->db->join('customer AS c', 'c.c_id = r.c_id');
		$this->db->where('m_id', $this->session->userdata('id'));
		return $this->db->get('report AS r')->result_array();
	}

	public function loadgoodsimg($id){
		$this->db->where('g_id', $id);
		$this->db->select('g_img');
		return $this->db->get('goods')->result_array();
	}

	public function deletegoods($gimg){
		$this->db->where('g_img', $gimg);
		$this->db->where('m_id', $this->session->userdata('id'));
		return $this->db->delete('goods');
	}

	public function loadpromotion() {
		$this->db->join('market AS m', 'm.m_id = p.m_id');
		$this->db->join('goods AS g', 'g.g_id = p.g_id');
		$this->db->where('p.m_id', $this->session->userdata('m_id'));
        return $this->db->get('promotion AS p')->result_array();
	}

	public function loadpromotionid($g_id) {
		$this->db->where('g_id', $g_id);
		$this->db->where('m_id', $this->session->userdata('m_id'));
        return $this->db->get('promotion')->result_array();
	}

	public function addPromotion() {
		$this->db->where('m_id', $this->session->userdata('m_id'));
		$this->db->where('p_id', null);
        return $this->db->get('goods AS g')->result_array();
	}

	public function loadgoodsidname($g_name) {
		$this->db->where('m_id', $this->session->userdata('m_id'));
		$this->db->where('g_name', $g_name);
        return $this->db->get('goods')->result_array();
	}

	


}
<?php 
class ReportModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	// public function loadRegist() {
	// 	$this->db->order_by('regist_year', 'DESC');
	// 	$this->db->order_by('regist_term', 'DESC');
	// 	return $this->db->get('regist')->result_array();
	// }
	public function loadYear() {
		$this->db->select('regist_year');
		$this->db->group_by('regist_year');
		$this->db->order_by('regist_year', 'DESC');
		return $this->db->get('regist')->result_array();
	}
	public function loadTerm($post) {
		$this->db->select('regist_term');
		$this->db->where('regist_year', $post['regist_year']);
		$this->db->order_by('regist_term', 'DESC');
		return $this->db->get('regist')->result_array();
	}
	public function loadRound($post) {
		$this->db->join('regist AS re', 're.regist_id = ro.regist_id');
		$this->db->where('re.regist_year', $post['regist_year']);
		$this->db->where('re.regist_term', $post['regist_term']);
		$this->db->order_by('ro.round_num', 'DESC');
		return $this->db->get('round AS ro')->result_array();
	}

	public function loadReportRound($post) {
		$where = '';
		$group = '';
		if($post['regist_year'] != '') {
			$where = " AND re.regist_year = '{$post['regist_year']}'";
			$group = ', re.regist_year';
			if($post['regist_term'] != '') {
				$where .= " AND re.regist_term = {$post['regist_term']}";
				$group .= ', re.regist_term';
				if($post['round_id'] != '') {
					$where = " AND ro.round_id = {$post['round_id']}";
					$group = ', ro.round_id';
				}
			}
		}
		return $this->db->query("
			SELECT w.*, ro.*, re.*, p.*, SUM(w.total) AS sum
			FROM working AS w
			LEFT JOIN round		AS ro ON ro.round_id	= w.round_id
			LEFT JOIN regist	AS re ON re.regist_id	= ro.regist_id
			LEFT JOIN profile	AS p ON p.username		= w.student_id
			WHERE ro.round_id IS NOT NULL{$where}
			GROUP BY w.student_id{$group}
		")->result_array();
	}

	public function loadRoundRegistid($regist_id){
		$this->db->join('regist AS re', 're.regist_id = r.regist_id');
		$this->db->where('r.regist_id', $regist_id);
		$this->db->order_by('r.round_num DESC');
		return $this->db->get('round AS r')->result_array();
	}
}
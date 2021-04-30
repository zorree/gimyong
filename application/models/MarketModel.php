<?php 
class MarketModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function loadmarket() {
		$this->db->where('m_id', $this->session->userdata('m_id'));
		return $this->db->get('market')->result_array();
	}

	public function goods(){
		$this->db->where('m_id', $this->session->userdata('m_id'));
		return $this->db->get('goods')->result_array();
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

	
	
	public function loadDeptS() {
		$this->db->select('d.*, j.*, p.*, COALESCE(s.total, 0) AS total');
		$this->db->join('job AS j', 'j.job_id = d.job_id');
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->join("(
			SELECT COUNT(s.student_id) AS total, s.dept_id
			FROM student AS s
			GROUP BY s.dept_id
		) AS s", 's.dept_id = d.dept_id', 'left');
		$this->db->where('d.dept_admin', $this->session->userdata('username'));
		$this->db->where('d.dept_status', 3);
        return $this->db->get('dept AS d')->result_array();
	}
	public function checkDept($dept_id) {
		$this->db->where('d.dept_admin', $this->session->userdata('username'));
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}
	public function checkDeptStudent($dept_id, $student_id) {
		$this->db->join('student AS s', 's.dept_id = d.dept_id');
		$this->db->where('d.dept_admin', $this->session->userdata('username'));
		$this->db->where('s.student_id', $student_id);
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}
	public function loadWorkingDeptStudent($dept_id, $student_id) {
		$this->db->where('w.dept_id', $dept_id);
		$this->db->where('w.student_id', $student_id);
		return $this->db->get('working AS w')->result_array();
	}
	public function deleteStudentDept($dept_id, $student_id){
		$this->db->where('dept_id', $dept_id);
		$this->db->where('student_id', $student_id);
		$this->db->delete('student');
	}

	public function checkStudent($dept_id, $student_id) {
		$this->db->join('dept AS d', 'd.dept_id = s.dept_id');
		$this->db->where('d.dept_admin', $this->session->userdata('username'));
		$this->db->where('d.dept_id', $dept_id);
		$this->db->where('s.student_id', $student_id);
		return $this->db->get('student AS s')->result_array();
	}
	public function loadStudentDeptid($dept_id) {
		$this->db->select('d.*, s.*, p1.div_name AS ddiv_name, p2.name, p2.div_name AS sdiv_name');
		$this->db->join('dept AS d', 'd.dept_id = s.dept_id');
		$this->db->join('profile AS p1', 'p1.username = d.dept_admin', 'left');
		$this->db->join('profile AS p2', 'p2.username = s.student_id', 'left');
		$this->db->where('s.dept_id', $dept_id);
		return $this->db->get('student AS s')->result_array();
	}
	public function loadWorking($dept_id, $student_id){
		$this->db->join('round AS ro', 'ro.round_id = w.round_id', 'left');
		$this->db->join('regist AS re', 're.regist_id = ro.regist_id', 'left');
		$this->db->where('w.dept_id', $dept_id);
		$this->db->where('w.student_id', $student_id);
		$this->db->order_by('w.working_start');
		return $this->db->get('working AS w')->result_array();
	}

	public function loadDeptid($dept_id){
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}
	public function loadRegistid($regist_id){
		$this->db->where('r.regist_id', $regist_id);
		return $this->db->get('regist AS r')->result_array();
	}

	public function loadRegist(){
		$this->db->select('r.*, j.*, d.name, d.div_name');
		$this->db->select('d.dept_id, d.dept_admin, d.dept_description, d.dept_property, d.dept_time, d.dept_fac, d.dept_gender, d.dept_tel, d.job_id, d.dept, d.dept_status');
		$this->db->select('s.student_id, s.student_status');
		$this->db->join("(
			SELECT *
			FROM dept AS d
			LEFT JOIN profile AS p ON p.username = d.dept_admin
			WHERE d.dept_admin = '{$this->session->userdata('username')}'
		) AS d", 'd.regist_id = r.regist_id', 'left');
		$this->db->join('job AS j', 'j.job_id = d.job_id', 'left');
		$this->db->join('student AS s', 's.dept_id = d.dept_id', 'left');
		$this->db->order_by('r.regist_year DESC');
		$this->db->order_by('r.regist_term DESC');
		return $this->db->get('regist AS r')->result_array();
	}

	public function loadStudentid($student_id){
		$this->db->join('profile AS p', 'p.username = s.student_id', 'left');
		$this->db->where('s.student_id', $student_id);
		return $this->db->get('student AS s')->result_array();
	}

	public function deleteStudentS($dept_id, $student_id){
		$this->db->where('dept_id', $dept_id);
		$this->db->where('student_id', $student_id);
		return $this->db->delete('student')->result_array();
	}

	public function loadStudentidRegistid($regist_id, $student_id){
		$this->db->where('student.regist_id', $regist_id);
		$this->db->where('student.student_id', $student_id);
		return $this->db->get('student')->result_array();
	}

	public function loadAddress($regist_id, $student_id){
		$this->db->select('p.*, d.zip_code, d.district_name, a.amphure_name, pr.province_name');
		$this->db->join('district AS d', 'd.district_id = p.district_id');
		$this->db->join('amphure AS a', 'a.amphure_id = d.amphure_id');
		$this->db->join('province AS pr', 'pr.province_id = a.province_id');
		$this->db->where('p.student_id', $student_id);
		$this->db->where('p.regist_id', $regist_id);
		return $this->db->get('address AS p')->result_array();
	}

	public function loadParent($regist_id, $student_id){
		$this->db->where('p.student_id', $student_id);
		$this->db->where('p.regist_id', $regist_id);
		return $this->db->get('parent AS p')->result_array();
	}

}
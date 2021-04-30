<?php 
class StudentModel extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function loadStudent(){
		$this->db->select('s.*, j.*, p.*');
		$this->db->select('r.dept_start, r.dept_stop, r.regist_term, r.regist_year');
		$this->db->select('d.dept_admin, d.dept_description, d.dept_property, d.dept_time, d.dept_gender, d.dept_tel, d.job_id, d.dept, d.dept_status');
		$this->db->join('regist AS r', 'r.regist_id = s.regist_id', 'left');
		$this->db->join('dept AS d', 'd.dept_id = s.dept_id', 'left');
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->join('job AS j', 'j.job_id = d.job_id', 'left');
		$this->db->where('s.student_id', $this->session->userdata('username'));
		return $this->db->get('student AS s')->result_array();
	}

	public function registNow(){
		$now1 = date('Y-m-d H:i:s');
		$now2 = date('Y-m-d H:i:s', time() - 86400);
		return $this->db->query("
			SELECT *
			FROM regist
			WHERE '{$now1}' >= regist_start AND '{$now2}' < regist_stop
		")->result_array();
	}
	public function loadAddress(){
		$this->db->select('p.*, d.zip_code, d.district_name, a.amphure_name, pr.province_name');
		$this->db->join('district AS d', 'd.district_id = p.district_id');
		$this->db->join('amphure AS a', 'a.amphure_id = d.amphure_id');
		$this->db->join('province AS pr', 'pr.province_id = a.province_id');
		$this->db->where('p.student_id', $this->session->userdata('username'));
		$this->db->where('p.regist_id IS NULL');
		return $this->db->get('address AS p')->result_array();
	}
	public function loadParent(){
		$this->db->where('p.student_id', $this->session->userdata('username'));
		$this->db->where('p.regist_id IS NULL');
		return $this->db->get('parent AS p')->result_array();
	}
	public function loadDeptid($dept_id){
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}
	public function checkDeptRegistStudent($regist_id, $dept_id){
		$this->db->join('student AS s', 's.dept_id = d.dept_id', 'left');
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->where("(d.dept_gender = 'B' OR d.dept_gender = '{$this->session->userdata('gender')}')");
		$this->db->where("(d.dept_fac = 0 OR p.fac = '{$this->session->userdata('fac')}')");
		$this->db->where('d.regist_id', $regist_id);
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}
	public function loadRegistid($regist_id){
		$this->db->where('r.regist_id', $regist_id);
		return $this->db->get('regist AS r')->result_array();
	}

	public function checkDept($dept_id){
		$this->db->join('student AS s', 's.dept_id = d.dept_id');
		$this->db->where('s.student_id', $this->session->userdata('username'));
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}
	public function checkOverlap($start, $stop, $dept_id){
		return $this->db->query("
			SELECT *
			FROM working AS w
			WHERE '{$start}' < w.working_stop AND w.working_start < '{$stop}'
				AND w.student_id = '{$this->session->userdata('username')}' AND w.dept_id = {$dept_id}
				AND w.working_status != 0
		")->result_array();
	}

	public function loadStudentid(){
		$this->db->join('profile AS p', 'p.username = s.student_id', 'left');
		$this->db->where('s.student_id', $this->session->userdata('username'));
		return $this->db->get('student AS s')->result_array();
	}

	public function loadWorkingStatus2($dept_id){
		$this->db->where('w.dept_id', $dept_id);
		$this->db->where('w.student_id', $this->session->userdata('username'));
		$this->db->where('w.working_status', 2);
		$this->db->where('w.round_id IS NULL');
		return $this->db->get('working AS w')->result_array();

	}

	public function loadWorking($dept_id){
		$this->db->join('round AS ro', 'ro.round_id = w.round_id', 'left');
		$this->db->join('regist AS re', 're.regist_id = ro.regist_id', 'left');
		$this->db->where('w.dept_id', $dept_id);
		$this->db->where('w.student_id', $this->session->userdata('username'));
		$this->db->order_by('w.working_start');
		return $this->db->get('working AS w')->result_array();
	}

	public function studentSelectDept($regist_id, $dept_id){
		$this->db->set('dept_id', $dept_id);
		$this->db->where('regist_id', $regist_id);
		$this->db->where('student_id', $this->session->userdata('username'));
		$this->db->update('student');
	}
	public function loadDeptRegistid($regist_id) {
		$this->db->select('d.*, j.*, p.*, s.student_id');
		$this->db->join('student AS s', 's.dept_id = d.dept_id', 'left');
		$this->db->join('job AS j', 'j.job_id = d.job_id', 'left');
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->where("(d.dept_gender = 'B' OR d.dept_gender = '{$this->session->userdata('gender')}')");
		$this->db->where("(d.dept_fac = 0 OR p.fac = '{$this->session->userdata('fac')}')");
		$this->db->where('d.regist_id', $regist_id);
		$this->db->where('d.dept_status', '2');
		return $this->db->get('dept AS d')->result_array();
	}
	public function addrSearch($addr) {
		return $this->db->query("
			SELECT d.district_id, d.zip_code, d.district_name, a.amphure_name, p.province_name, g.geography_name
			FROM district AS d
			LEFT JOIN amphure AS a ON a.amphure_id = d.amphure_id
			LEFT JOIN province AS p ON p.province_id = a.province_id
			LEFT JOIN geography AS g ON g.geography_id = p.geography_id
			WHERE d.district_name LIKE '%{$addr}%' OR a.amphure_name LIKE '%{$addr}%' OR p.province_name LIKE '%{$addr}%' OR d.zip_code LIKE '{$addr}%'
			ORDER BY (
			CASE
			WHEN d.district_name	= '{$addr}' THEN 1
			WHEN a.amphure_name		= '{$addr}' THEN 2
			WHEN p.province_name	= '{$addr}' THEN 3
			WHEN d.district_name	LIKE '{$addr}%' THEN 4
			WHEN a.amphure_name		LIKE '{$addr}%' THEN 5
			WHEN p.province_name	LIKE '{$addr}%' THEN 6
			ELSE 7
			END
			), d.district_name, a.amphure_name, p.province_name
			LIMIT 10
			")->result_array();
	}

	public function register($ar, $regist_id) {
		$condition	= true;

		if($regist_id != '') {
			$this->db->where('regist_id', $regist_id);
			$regist = $this->db->get('regist')->result_array();

			if(count($regist) > 0) {
				$now = time();
				$start = strtotime($regist[0]['regist_start']);
				$stop = strtotime('+1 day', strtotime($regist[0]['regist_stop']));
				$condition = ($now >= $start && $now < $stop);
			}
		}
		$condition ?: redirect('student');

		$this->db->where('student_id', $this->session->userdata('username'));
		$this->db->where('regist_id IS NULL');
		$this->db->delete('address');

		$this->db->where('student_id', $this->session->userdata('username'));
		$this->db->where('regist_id IS NULL');
		$this->db->delete('parent');

		$this->db->where('username', $this->session->userdata('username'));
		$this->db->delete('profile');

		$ar['profile'] = [
			'username'	=> $this->session->userdata('username'),
			'name'		=> $this->session->userdata('name'),
			'name_en'	=> $this->session->userdata('name_en'),
			'div_id'	=> $this->session->userdata('dept_id'),
			'div_name'	=> $this->session->userdata('dept_name'),
			'gender'	=> $this->session->userdata('gender'),
			'fac'		=> $this->session->userdata('fac'),
			'mobile'	=> $ar['profile']['mobile'],
			'email'		=> $ar['profile']['email'],
			'bank'		=> $ar['profile']['bank'],
		];
		$this->db->insert('profile', $ar['profile']);

		$now = date('Y-m-d H:i:s');
		$ar['address']['timestamp'] = $now;
		$ar['parent']['timestamp'] = $now;
		
		$this->db->insert('address', $ar['address']);
		$this->db->insert('parent', $ar['parent']);

		if($regist_id != '') {
			$this->db->where('student_id', $this->session->userdata('username'));
			$this->db->where('regist_id', $regist_id);
			$this->db->delete('address');

			$this->db->where('student_id', $this->session->userdata('username'));
			$this->db->where('regist_id', $regist_id);
			$this->db->delete('parent');

			$ar['address']['regist_id'] = $regist_id;
			$ar['parent']['regist_id'] = $regist_id;
			$this->db->insert('address', $ar['address']);
			$this->db->insert('parent', $ar['parent']);

			$this->db->where('student_id', $this->session->userdata('username'));
			$this->db->where('regist_id', $regist_id);
			$student = $this->db->get('student')->result_array();
			if(count($student) == 0) {
				$this->db->set('student_id', $this->session->userdata('username'));
				$this->db->set('regist_id', $regist_id);
				$this->db->insert('student');
			}
			redirect('student/history');
		}

		redirect('student');
	}

	public function checkWorkingStatus($working_id){
		$this->db->where('w.student_id', $this->session->userdata('username'));
		$this->db->where('w.working_id', $working_id);
		$this->db->where('w.working_status !=', 2);
		return $this->db->get('working AS w')->result_array();
	}

	public function loadStudentidRegistid($regist_id){
		$this->db->where('student.regist_id', $regist_id);
		$this->db->where('student.student_id', $this->session->userdata('username'));
		return $this->db->get('student')->result_array();
	}

	public function loadAddressRegist_id($regist_id){
		$this->db->select('p.*, d.zip_code, d.district_name, a.amphure_name, pr.province_name');
		$this->db->join('district AS d', 'd.district_id = p.district_id');
		$this->db->join('amphure AS a', 'a.amphure_id = d.amphure_id');
		$this->db->join('province AS pr', 'pr.province_id = a.province_id');
		$this->db->where('p.student_id', $this->session->userdata('username'));
		$this->db->where('p.regist_id', $regist_id);
		return $this->db->get('address AS p')->result_array();
	}

	public function loadParentRegist_id($regist_id){
		$this->db->where('p.student_id', $this->session->userdata('username'));
		$this->db->where('p.regist_id', $regist_id);
		return $this->db->get('parent AS p')->result_array();
	}

	public function deleteDept($regist_id){
		$this->db->where('s.student_id', $this->session->userdata('username'));
		$this->db->where('s.regist_id', $regist_id);
		$this->db->set('s.dept_id', null);
		$this->db->update('student AS s');
	}

}
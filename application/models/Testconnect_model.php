<?php 
class Testconnect_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	//Market

	public function load_testconnect() {
        return $this->db->get('db')->result_array();
	}

	public function insert($name,$lname){
        $data = array(
            'name' => $name,
            'lname' => $lname,
        );
		$this->db->insert('db', $data);
    }

    public function delete($id){
        $this->db->where('db_id', $id);
		$this->db->delete('db');
    }
    



	public function goods($id){
		$this->db->where('m_id', $id);
		return $this->db->get('goods')->result_array();
	}

	//Customer

	public function loadcustomer() {
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

	//Promotion

	public function loadpromotion() {
		$this->db->join('market AS m', 'm.m_id = p.m_id');
		$this->db->join('goods AS g', 'g.g_id = p.g_id');
        return $this->db->get('promotion AS p')->result_array();
	}
	


	public function duplicateRegist($term, $year) {
		$this->db->where('regist_term', $term);
		$this->db->where('regist_year', $year);
        $result = $this->db->get('regist')->result_array();
        return count($result) > 0 ? true : false;
	}
	public function toggleEnabled($admin_id, $enabled) {
		$this->db->where('admin_id', $admin_id);
		$this->db->set('enabled', (1 - $enabled));
		$this->db->update('admin');
	}
	public function dept_admin($admin_id) {
		$this->db->where('dept_status', 3);
		$this->db->where('dept_admin', $admin_id);
        return $this->db->get('dept')->result_array();
	}
	public function loadAdmin() {
		$this->db->order_by('enabled', 'DESC');
		$this->db->order_by('admin_level', 'ASC');
		$this->db->order_by('admin_id', 'ASC');
        return $this->db->get('admin')->result_array();
	}
	
	public function countDept($regist_id) {
		$this->db->select('COUNT(dept_id) AS dept, regist_id, dept_status');
		$this->db->where('regist_id', $regist_id);
		$this->db->group_by('regist_id, dept_status');
        return $this->db->get('dept')->result_array();
	}
	public function countStudent($regist_id) {
		$this->db->select('COUNT(student_id) AS student, regist_id, student_status');
		$this->db->where('regist_id', $regist_id);
		$this->db->group_by('regist_id, student_status');
        return $this->db->get('student')->result_array();
	}
	public function loadDeptS() {
		$this->db->select('d.*, j.*, p.*, COALESCE(s.total, 0) AS total');
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->join('job AS j', 'j.job_id = d.job_id');
		$this->db->join("(
			SELECT COUNT(s.student_id) AS total, s.dept_id
			FROM student AS s
			GROUP BY s.dept_id
		) AS s", 's.dept_id = d.dept_id', 'left');
		$this->db->where('d.dept_status', 3);
        return $this->db->get('dept AS d')->result_array();
	}
	public function loadStudentS() {
		$this->db->select('d.*, s.*, p1.div_name AS ddiv_name, p2.name, p2.div_name AS sdiv_name');
		$this->db->join('dept AS d', 'd.dept_id = s.dept_id');
		$this->db->join('profile AS p1', 'p1.username = d.dept_admin', 'left');
		$this->db->join('profile AS p2', 'p2.username = s.student_id', 'left');
		$this->db->where('s.student_status', 4);
		return $this->db->get('student AS s')->result_array();
	}
	public function loadDeptRegistid($regist_id) {
		$this->db->select('d.*, j.*, p.*, s.student_id');
		$this->db->join('job AS j', 'j.job_id = d.job_id');
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->join('student AS s', 's.dept_id = d.dept_id', 'left');
		$this->db->where('d.regist_id', $regist_id);
		$this->db->order_by('(case d.dept_status when 0 then 2 else 1 end), d.dept_status');
        return $this->db->get('dept AS d')->result_array();
	}
	public function loadStudentDeptid($dept_id) {
		$this->db->select('s.*');
		$this->db->select('p1.name AS sname, p1.div_name AS sdiv_name');
		$this->db->select('p2.name AS dname, p2.div_name AS ddiv_name');
		$this->db->join('dept AS d', 'd.dept_id = s.dept_id', 'left');
		$this->db->join('profile AS p1', 'p1.username = s.student_id', 'left');
		$this->db->join('profile AS p2', 'p2.username = d.dept_admin', 'left');
		$this->db->where('s.dept_id', $dept_id);
		return $this->db->get('student AS s')->result_array();
	}

	public function loadStudentWoring($regist_id, $student_id = false) {
		$this->db->select('s.*');
		$this->db->select('p1.name AS sname, p1.div_name AS sdiv_name');
		$this->db->select('p2.name AS dname, p2.div_name AS ddiv_name');
		$this->db->join('dept AS d', 'd.dept_id = s.dept_id', 'left');
		$this->db->join('profile AS p1', 'p1.username = s.student_id', 'left');
		$this->db->join('profile AS p2', 'p2.username = d.dept_admin', 'left');
		$this->db->where('s.regist_id', $regist_id);
		$student_id ? $this->db->where('s.student_id', $student_id) : '';
		$this->db->where('s.student_status', '3');
		$this->db->order_by('s.student_id');
		return $this->db->get('student AS s')->result_array();
	}
	public function loadStudentRegistid($regist_id) {
		$this->db->select('s.*');
		$this->db->select('p1.name AS sname, p1.div_name AS sdiv_name');
		$this->db->select('p2.name AS dname, p2.div_name AS ddiv_name');
		$this->db->join('dept AS d', 'd.dept_id = s.dept_id', 'left');
		$this->db->join('profile AS p1', 'p1.username = s.student_id', 'left');
		$this->db->join('profile AS p2', 'p2.username = d.dept_admin', 'left');
		$this->db->where('s.regist_id', $regist_id);
		$this->db->order_by('(
			CASE
				WHEN s.student_status = 1 THEN 1
				WHEN s.student_status = 2 AND s.dept_id IS NOT NULL THEN 2
				WHEN s.student_status = 3 THEN 2
				WHEN s.student_status = 2 AND s.dept_id IS NULL THEN 4
				WHEN s.student_status = 0 AND s.dept_id IS NOT NULL THEN 5
				ELSE 6
			END
		)');
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

	public function loadRoundRegistid($regist_id){
		$this->db->join('regist AS re', 're.regist_id = ro.regist_id', 'left');
		$this->db->where('re.regist_id', $regist_id);
		$this->db->order_by('re.regist_year DESC, re.regist_term DESC, ro.round_num DESC');
		return $this->db->get('round AS ro')->result_array();
	}
	public function loadRegistOrderby(){
		$this->db->order_by('re.regist_year DESC');
		$this->db->order_by('re.regist_term DESC');
		return $this->db->get('regist AS re')->result_array();
	}
	public function loadDeptid($dept_id){
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->join('regist AS r', 'r.regist_id = d.regist_id', 'left');
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}

	public function checkStudent($dept_id, $student_id) {
		$this->db->where('s.dept_id', $dept_id);
		$this->db->where('s.student_id', $student_id);
		return $this->db->get('student AS s')->result_array();
	}

	public function deleteStudentDept($dept_id, $student_id){
		$this->db->where('dept_id', $dept_id);
		$this->db->where('student_id', $student_id);
		$this->db->delete('student');
	}

	public function loadWorkingDeptStudent($dept_id, $student_id) {
		$this->db->where('w.dept_id', $dept_id);
		$this->db->where('w.student_id', $student_id);
		return $this->db->get('working AS w')->result_array();
	}

	public function checkDept($dept_id, $dept_admin) {
		$this->db->where('d.dept_admin', $dept_admin);
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}

	public function loadStudentidRegistid($regist_id, $student_id){
		$this->db->where('student.regist_id', $regist_id);
		$this->db->where('student.student_id', $student_id);
		return $this->db->get('student')->result_array();
	}
	public function loadStudentid($student_id){
		$this->db->join('profile AS p', 'p.username = s.student_id', 'left');
		$this->db->where('s.student_id', $student_id);
		return $this->db->get('student AS s')->result_array();
	}

	public function approveStudent($student_id, $regist_id, $ar){
		$this->db->where('student_id', $student_id);
		$this->db->where('regist_id', $regist_id);
		$this->db->update('student', $ar);
	}

	public function studentDeleteDept($student_id, $dept_id){
		$this->db->set('dept_id', null);
		$this->db->where('student_id', $student_id);
		$this->db->where('dept_id', $dept_id);
		$this->db->update('student');
	}
	public function loadRound($dept_id){
		$this->db->where('dept.dept_id', $dept_id);
		$dept = $this->db->get('dept')->result_array();

		$this->db->join('regist AS re', 're.regist_id = ro.regist_id', 'left');
		$dept[0]['regist_id'] != null ? $this->db->where('ro.regist_id', $dept[0]['regist_id']) : '';
		$this->db->order_by('re.regist_year DESC, re.regist_term DESC, ro.round_num DESC');
		return $this->db->get('round AS ro')->result_array();
	}


	public function loadWorkingBefore($student_id, $working_stop){
		$this->db->where('student_id', $student_id);
		$this->db->where('working_stop <=', $working_stop);
		$this->db->where('working_status', 2);
		$this->db->where('round_id IS NULL');
		$this->db->order_by('working.working_start');
		return $this->db->get('working')->result_array();
	}
	public function addRound($student_id, $working_stop, $round_id){
		$this->db->set('round_id', $round_id);
		$this->db->where('student_id', $student_id);
		$this->db->where('working_stop <=', $working_stop);
		$this->db->where('working_status', 2);
		$this->db->where('round_id IS NULL');
		$this->db->update('working');
	}

	public function loadRoundRegistTermYear($regist_term, $regist_year){
		$this->db->select('re.*, ro.round_num');
		$this->db->join('round AS ro', 'ro.regist_id = re.regist_id', 'left');
		$this->db->where('re.regist_term', $regist_term);
		$this->db->where('re.regist_year', $regist_year);
		$this->db->order_by('ro.round_num DESC');
		return $this->db->get('regist AS re')->result_array();
	}
	public function loadRegistid($regist_id){
		$this->db->where('r.regist_id', $regist_id);
		return $this->db->get('regist AS r')->result_array();
	}

	public function loadDeptsid($dept_id){
		$this->db->join('profile AS p', 'p.username = d.dept_admin', 'left');
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}

	public function checkDeptStudent($dept_id, $student_id) {
		$this->db->join('student AS s', 's.dept_id = d.dept_id');
		$this->db->where('s.student_id', $student_id);
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}

	public function checkStudentDuplicate($student_id, $dept_id) {
		$this->db->join('student AS s', 's.dept_id = d.dept_id');
		$this->db->where('s.student_id', $student_id);
		$this->db->where('d.dept_id', $dept_id);
		return $this->db->get('dept AS d')->result_array();
	}

	

}
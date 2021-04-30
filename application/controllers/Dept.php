<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dept extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('DeptModel');
		$this->session->userdata('type') == 'admin' && $this->session->userdata('level') > 0 ?: redirect();
	}
	public function index() {
		$this->session->userdata('level') == 2 ?: redirect('dept/depts');

		$data['job'] = $this->PrepareModel->loadData('job');
		$data['listRegist'] = $this->DeptModel->loadRegist();
		$data['content'] = 'dept/index';
		$this->load->view('include/layout', $data);
	}
	public function depts() {
		$this->session->userdata('level') == 1 ?: redirect('dept');

		$data['job'] = $this->PrepareModel->loadData('job');
		$data['listDept'] = $this->DeptModel->loadDeptS();
		$data['content'] = 'dept/depts';
		$this->load->view('include/layout', $data);
	}

	public function editDept(){
		// print_r($this->input->post());
		// echo $this->session->userdata('username');
		if($this->input->post()){
			$dept_id			= $this->input->post('dept_id');
			$job_id				= $this->input->post('job_id');
			$dept_description	= $this->input->post('dept_description');
			$dept_property		= $this->input->post('dept_property');
			$dept_time			= $this->input->post('dept_time');
			$dept_gender		= $this->input->post('dept_gender');
			$dept_tel			= $this->input->post('dept_tel');
			$dept_fac			= $this->input->post('dept_fac');
			$ar = [
				'job_id'			=> $job_id,
				'dept_description'	=> $dept_description,
				'dept_property'		=> $dept_property,
				'dept_time'			=> $dept_time,
				'dept_gender'		=> $dept_gender,
				'dept_tel'			=> $dept_tel,
			];
			if($this->session->userdata('level') == 2) {
				$ar['dept_fac'] = $dept_fac;
			}
			$this->PrepareModel->updateData('dept', 'dept_id', $dept_id , $ar);
			redirect('dept');
		}
	}

	public function loadDeptid(){
		echo json_encode($this->DeptModel->loadDeptid($this->input->post('dept_id')));
	}

	public function apply($regist_id, $student_id){
		$data['student']	= $this->DeptModel->loadStudentidRegistid($regist_id, $student_id);
		if(count($data['student']) > 0) {
			$data['profile']	= $this->PrepareModel->loadDataid('profile', 'username', $student_id);
			$data['regist']		= $this->DeptModel->loadRegistid($regist_id);
			$data['address']	= $this->DeptModel->loadAddress($regist_id, $student_id);
			$data['parent']		= $this->DeptModel->loadParent($regist_id, $student_id);
			$data['content'] = 'dept/apply';
			$this->load->view('include/layout', $data);
		} else {
			redirect('admin');
		}

	}

	public function students($dept_id) {
		$this->session->userdata('level') == 1 ?: redirect('dept');
		$data['dept'] = $this->DeptModel->loadDeptid($dept_id);

		$data['listStudent'] = $this->DeptModel->loadStudentDeptid($dept_id);
		$data['content'] = 'dept/students';
		$this->load->view('include/layout', $data);
	}
	public function working($dept_id, $student_id) {
		$checkDept = $this->DeptModel->checkDeptStudent($dept_id, $student_id);
		count($checkDept) > 0 ?: redirect('dept');

		$data['dept'] = $this->DeptModel->loadDeptid($dept_id);
		$data['student'] = $this->DeptModel->loadStudentid($student_id);
		$data['listWorking'] = $this->DeptModel->loadWorking($dept_id, $student_id);
		$data['content'] = 'dept/working';
		$this->load->view('include/layout', $data);
	}

	public function deleteStudentS($dept_id, $student_id){
		$this->session->userdata('level') == 1 ?: redirect('dept');
		$checkStudent = $this->DeptModel->checkStudent($dept_id, $student_id);
		count($checkStudent) > 0 ?: redirect('dept');

		$working = $this->DeptModel->loadWorkingDeptStudent($dept_id, $student_id);
		if(count($working) > 0) {
			echo '<script>alert("นักศึกษามีชั่วโมงทำงานในหน่วยงานนี้แล้ว");window.location="'.site_url('dept/students/'.$dept_id).'";</script>';
		} else {
			$this->DeptModel->deleteStudentDept($dept_id, $student_id);
			redirect('dept/students/'.$dept_id);
		}
	}

	public function deleteDept($dept_id){
		$checkDept = $this->DeptModel->checkDept($dept_id);
		count($checkDept) > 0 ?: redirect('dept');

		$student = $this->PrepareModel->loadDataid('student', 'dept_id', $dept_id);
		if(count($student) > 0) {
			echo '<script>alert("มีนักศึกษาในหน่วยงานนี้แล้ว");window.location="'.site_url('dept/depts').'";</script>';
		} else {
			$this->PrepareModel->deleteData('dept', 'dept_id', $dept_id);
			redirect('dept/depts');
		}
	}

	public function addStudentS(){
		$dept_id = $this->input->post('dept_id');
		$student_id = $this->input->post('student_id');
		$this->session->userdata('level') == 1 ?: redirect('dept');
		$checkDept = $this->DeptModel->checkDeptStudent($dept_id, $student_id);
		
		if(count($checkDept) > 0 ){
			echo '<script>alert("มีนักศึกษาในหน่วยงานพิเศษนี้แล้ว");window.location="'.site_url('dept/students/'.$dept_id).'";</script>';
		}else {
			if($this->input->post()){
				$ar = [
					'student_id'		=> $student_id,
					'dept_id'			=> $dept_id,
					'student_status'	=> '4',
				];
				$this->PrepareModel->insertData('student', $ar);
				$this->PrepareModel->deleteData('profile', 'username', $student_id);
				$ar = [
					'username'	=> $student_id,
					'name'			=> "นาย{$student_id} นามสกุล",
					'name_en'		=> 'Fname Sname',
					'div_id'		=> '034',
					'div_name'	=> 'ภาควิชาวิศวกรรมคอมพิวเตอร์ คณะวิศวกรรมศาสตร์',
					'gender'		=> 'M',
				];
				$this->PrepareModel->insertData('profile', $ar);
			}
			redirect('dept/students/'.$dept_id);
		}
	}

	public function addDept() {
		// print_r($this->input->post());
		if($this->input->post()){
			$job_id				= $this->input->post('job_id');
			$dept_description	= $this->input->post('dept_description');
			$dept_property		= $this->input->post('dept_property');
			$dept_time			= $this->input->post('dept_time');
			$dept_gender		= $this->input->post('dept_gender');
			$dept_tel			= $this->input->post('dept_tel');
			$dept_status		= $this->input->post('dept_status');
			$dept_fac			= $this->input->post('dept_fac');
			$ar = [
				'dept_admin'		=> $this->session->userdata('username'),
				'job_id'			=> $job_id,
				'dept_description'	=> $dept_description,
				'dept_property'		=> $dept_property,
				'dept_time'			=> $dept_time,
				'dept_gender'		=> $dept_gender,
				'dept_tel'			=> $dept_tel,
				'dept_status'		=> $dept_status,
			];
			if($dept_status == 1) {
				$ar['dept_fac'] = $dept_fac;
				$regist_id = $this->input->post('regist_id');
				$regist = $this->DeptModel->loadRegistid($regist_id);
				$now = time();
				$start = strtotime($regist[0]['regist_start']);
				$stop = strtotime('+1 day', strtotime($regist[0]['regist_stop']));
				if($now >= $start && $now < $stop) {
					$ar['regist_id'] = $regist_id;
					$this->PrepareModel->insertData('dept', $ar);
				} else {
					redirect('dept');
				}
			} else {
				$dept_id = $this->PrepareModel->insertData('dept', $ar);
			}
			$this->PrepareModel->deleteData('profile', 'username', $this->session->userdata('username'));
			$ar = [
				'username'	=> $this->session->userdata('username'),
				'name'		=> $this->session->userdata('name'),
				'name_en'	=> $this->session->userdata('name_en'),
				'div_id'	=> $this->session->userdata('dept_id'),
				'div_name'	=> $this->session->userdata('dept_name'),
				'gender'	=> $this->session->userdata('gender'),
				'fac'	=> $this->session->userdata('fac'),
			];
			$this->PrepareModel->insertData('profile', $ar);
		}
		redirect('dept/'.($dept_status == 1 ? '' : 'students/'.$dept_id)); 
	}

	
	public function updateWorking($dept_id, $student_id, $working_id, $working_status){
		$checkDept = $this->DeptModel->checkDeptStudent($dept_id, $student_id);
		count($checkDept) > 0 ?: redirect('dept');
		$ar = [
			'working_status'		=> $working_status,
		];
		$this->PrepareModel->updateData('working', 'working_id', $working_id, $ar);
		redirect('dept/working/'.$dept_id.'/'.$student_id);
	}


	// public function addStudentS(){
	// 	$dept_id = $this->input->post('dept_id');
	// 	$student_id = $this->input->post('student_id');
	// 	$this->session->userdata('level') == 1 ?: redirect('dept');
	// 	$checkDept = $this->DeptModel->checkDeptStudent($dept_id, $student_id);
	// 	count($checkDept) == 0 ?: redirect('dept');

	// 	if($this->input->post()){
	// 		$ar = [
	// 			'student_id'		=> $student_id,
	// 			'dept_id'			=> $dept_id,
	// 			'student_status'	=> '4',
	// 		];
	// 		$this->PrepareModel->insertData('student', $ar);
	// 		$this->PrepareModel->deleteData('profile', 'username', $student_id);
	// 		$ar = [
	// 			'username'	=> $student_id,
	// 			'name'			=> "นาย{$student_id} นามสกุล",
	// 			'name_en'		=> 'Fname Sname',
	// 			'fac'			=> substr($student_id, 2, 2),
	// 			'div_id'		=> '034',
	// 			'div_name'	=> 'ภาควิชาวิศวกรรมคอมพิวเตอร์ คณะวิศวกรรมศาสตร์',
	// 			'gender'		=> 'M',
	// 		];
	// 		$this->PrepareModel->insertData('profile', $ar);
	// 	}
	// 	redirect('dept/students/'.$dept_id);
	// }

}
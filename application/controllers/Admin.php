<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct() {
		parent::__construct();
		header("Cache-Control: public, max-age=60, s-maxage=60");
		$this->load->model('AdminModel');
		$this->session->userdata('type') == 'admin' && $this->session->userdata('level') == 1 ?: redirect();
	}
	
	public function index() {
		$data['content'] = 'admin/index';
		$this->load->view('include/layout', $data);
	}

	//MARKET ZONE

	public function market() {
		$data['num']				= 0;
		$data['listmarket']			= $this->AdminModel->loadmarket();
		$data['countlistmarket']	= count($data['listmarket']);
		$data['content']			= 'admin/market';
		$this->load->view('include/layout', $data);
	}

	public function marketdetail($id) {
		if($id != null){
			$data['marketdetail'] = $this->AdminModel->marketdetail($id);
			$data['goods'] = $this->AdminModel->goods($id);
			$data['content'] = 'admin/marketdetail';
			$this->load->view('include/layout', $data);
		}else{
			redirect('admin/market');
		}
		
	}

	public function marketedit($id) {
		if($id != null){
			$data['marketdetail'] = $this->AdminModel->marketdetail($id);
			$data['goods'] = $this->AdminModel->goods($id);
			$data['content'] = 'admin/marketedit';
			$this->load->view('include/layout', $data);
		}else{
			redirect('admin/market');
		}
		
	}

	public function marketeditaction() {
		if($this->input->post()){
			$m_id			= $this->input->post('m_id');
			$m_name			= $this->input->post('m_name');
			$m_lname		= $this->input->post('m_lname');
			$m_shopname		= $this->input->post('m_shopname');
			$m_shoptype		= $this->input->post('m_shoptype');
			$m_shopdetail	= $this->input->post('m_shopdetail');
			$m_lat			= $this->input->post('m_lat');
			$m_lng			= $this->input->post('m_lng');
			$ar = [
				'm_id'			=> $m_id,
				'm_name'		=> $m_name,
				'm_lname'		=> $m_lname,
				'm_shopname'	=> $m_shopname,
				'm_shoptype'	=> $m_shoptype,
				'm_shopdetail'	=> $m_shopdetail,
				'm_lat'			=> $m_lat,
				'm_lng'			=> $m_lng,
			];
			$this->PrepareModel->updateData('market', 'm_id', $m_id , $ar);
			echo '<script>alert("แก้ไขข้อมูลสำเร็จ");window.location="'.site_url("admin/marketdetail/{$m_id}").'";</script>';
			// redirect("admin/marketdetail/{$m_id}");
		}
	}

	//CUSTOMER ZONE

	public function customer() {
		$data['listcustomer'] = $this->AdminModel->loadcustomer();
		$data['content'] = 'admin/customer';
		$this->load->view('include/layout', $data);
	}	

	public function customerdetail($id) {
		if($id != null){
			$data['customerdetail'] = $this->AdminModel->customerdetail($id);
			$data['scoredetail'] 	= $this->AdminModel->scoredetail($id);
			$data['content'] = 'admin/customerdetail';
			$this->load->view('include/layout', $data);
		}else{
			redirect('admin/market');
		}
	}

	public function customeredit() {
		if($this->input->post()){
			$id = $this->input->post('c_id');
			$data['customerdetail'] = $this->AdminModel->customeredit($id);
			$data['content'] = 'admin/customeredit';
			$this->load->view('include/layout', $data);
		}else{
			redirect('admin/market');
		}
	}


	//PROMOTION ZONE

	public function promotion() {
		$data['listpromotion'] = $this->AdminModel->loadpromotion();
		$data['content'] = 'admin/promotion';
		$this->load->view('include/layout', $data);
	}

	//GOODS ZONE

	public function goodsdetail($id){
		if($id != null){
			$data['customerdetail'] = $this->AdminModel->customeredit($id);
			$data['content'] = 'admin/goodsdetail';
			$this->load->view('include/layout', $data);
		}else{
			redirect('admin/market');
		}
	}




	public function editRegist(){
		// print_r($this->input->post());
		// echo $this->session->userdata('username');
		if($this->input->post()){
			$regist_id			= $this->input->post('regist_id');
			$regist_term		= $this->input->post('regist_term');
			$regist_year		= $this->input->post('regist_year');
			$regist_start		= $this->input->post('regist_start');
			$regist_stop		= $this->input->post('regist_stop');
			$dept_start			= $this->input->post('dept_start');
			$dept_stop			= $this->input->post('dept_stop');
			$ar = [
				'regist_term'		=> $regist_term,
				'regist_year'		=> $regist_year,
				'regist_start'		=> $regist_start,
				'regist_stop'		=> $regist_stop,
				'dept_start'		=> $dept_start,
				'dept_stop'			=> $dept_stop,
			];
			$this->PrepareModel->updateData('regist', 'regist_id', $regist_id , $ar);
			redirect('admin');
		}
	}

	public function loadRegistid(){
		echo json_encode($this->AdminModel->loadRegistid($this->input->post('regist_id')));
	}

	public function loadWorkingBefore(){
		$working = $this->PrepareModel->loadDataid('working', 'working_id', $this->input->post('working_id'));
		echo json_encode($this->AdminModel->loadWorkingBefore($working[0]['student_id'], $working[0]['working_stop']));
	}

	public function dept($regist_id) {
		$data['regist'] = $this->PrepareModel->loadDataid('regist', 'regist_id', $regist_id);
		$data['listDept'] = $this->AdminModel->loadDeptRegistid($regist_id);
		$data['content'] = 'admin/dept';
		$this->load->view('include/layout', $data);
	}

	public function approveDept($dept_id, $dept_status, $regist_id){
		$ar = [
			'dept_status' => $dept_status
		];
		$this->PrepareModel->updateData('dept', 'dept_id', $dept_id, $ar);
		redirect('admin/dept/'.$regist_id);
	}

	
	public function approveStudent($student_id, $student_status, $regist_id, $deptNull = false){
		$ar = [
			'student_status' => $student_status
		];
		if($deptNull) {
			$ar['dept_id'] = null;
		}
		$this->AdminModel->approveStudent($student_id, $regist_id, $ar);
		$deptNull ? redirect('admin/dept/'.$regist_id) : redirect('admin/student/'.$regist_id);
	}

	public function students($dept_id) {
		$data['dept'] = $this->AdminModel->loadDeptsid($dept_id);
		$data['listStudent'] = $this->AdminModel->loadStudentDeptid($dept_id);
		$data['content'] = 'admin/students';
		$this->load->view('include/layout', $data);
	}

	public function student($regist_id) {
		$data['studentWorking']	= $this->AdminModel->loadStudentWoring($regist_id);
		$data['regist']		= $this->PrepareModel->loadDataid('regist', 'regist_id', $regist_id);
		$data['student']	= $this->AdminModel->loadStudentRegistid($regist_id);
		$data['content']	= 'admin/student';
		$this->load->view('include/layout', $data);
	}
	public function admin() {
		$data['listAdmin'] = $this->AdminModel->loadAdmin();
		$data['content'] = 'admin/admin';
		$this->load->view('include/layout', $data);
	}

	public function working($dept_id, $student_id) {
		$data['regist'] = $this->AdminModel->loadRegistOrderby();
		$data['round'] = $this->AdminModel->loadRound($dept_id);
		$data['dept'] = $this->AdminModel->loadDeptid($dept_id);
		$data['student'] = $this->AdminModel->loadStudentid($student_id);
		$data['listWorking'] = $this->AdminModel->loadWorking($dept_id, $student_id);
		$data['content'] = 'admin/working';
		$this->load->view('include/layout', $data);
	}

	public function apply($regist_id, $student_id){
		$data['student']	= $this->AdminModel->loadStudentidRegistid($regist_id, $student_id);
		if(count($data['student']) > 0) {
			$data['profile']	= $this->PrepareModel->loadDataid('profile', 'username', $student_id);
			$data['regist']		= $this->AdminModel->loadRegistid($regist_id);
			$data['address']	= $this->AdminModel->loadAddress($regist_id, $student_id);
			$data['parent']		= $this->AdminModel->loadParent($regist_id, $student_id);
			$data['content'] = 'admin/apply';
			$this->load->view('include/layout', $data);
		} else {
			redirect('admin');
		}

	}

	public function toggleEnabled($admin_id, $enabled) {
		if($this->session->userdata('username') != $admin_id) {
			$this->AdminModel->toggleEnabled($admin_id, $enabled);
			redirect('admin/admin');
		}
	}

	public function addAdmin() {
		if($this->input->post()){
			$ar = [
				'admin_id'	=> $this->input->post('admin_id'),
				'admin_level'	=> $this->input->post('admin_level')
			];
			$this->PrepareModel->insertData('admin', $ar);
		}
		redirect('admin/admin');
	}

	public function deleteRegist($regist_id){
		$dept = $this->PrepareModel->loadDataid('dept', 'regist_id', $regist_id);
		$student = $this->PrepareModel->loadDataid('student', 'regist_id', $regist_id);
		if(count($dept) > 0 || count($student) > 0 ) {
			echo '<script>alert("มีการสมัครจากรอบการทำงานนี้แล้ว");window.location="'.site_url('admin').'";</script>';
		} else {
			$this->PrepareModel->deleteData('regist', 'regist_id', $regist_id);
			redirect('admin');
		}
	}
	public function cancelRound($working_id, $dept_id, $student_id){
		$ar = [
			'round_id'	=> null,
		];
		$this->PrepareModel->updateData('working', 'working_id', $working_id, $ar);
		redirect("admin/working/{$dept_id}/{$student_id}");
	}
	

	public function studentDeleteDept($student_id, $dept_id, $regist_id){
		$this->AdminModel->studentDeleteDept($student_id, $dept_id);
		redirect('admin/student/'.$regist_id);
	}

	public function deleteAdmin($admin_id) {
		$dept = $this->PrepareModel->loadDataid('dept', 'dept_admin', $admin_id);
		if(count($dept) > 0) {
			echo '<script>alert("มีหน่วยงานจากผู้ใช้งานนี้แล้ว");window.location="'.site_url('admin/admin').'";</script>';
		} else {
			$this->PrepareModel->deleteData('admin', 'admin_id', $admin_id);
			redirect('admin/admin');
		}
	}

	public function addRegist() {
		$regist_start	= $this->input->post('regist_start');
		$regist_stop	= $this->input->post('regist_stop');
		$dept_start		= $this->input->post('dept_start');
		$dept_stop		= $this->input->post('dept_stop');
		if($this->input->post() && $regist_start <= $regist_stop && $dept_start <= $dept_stop){
			$term	= $this->input->post('term');
			$year	= $this->input->post('year');
			$duplicateRegist = $this->AdminModel->duplicateRegist($term, $year);
			if(!$duplicateRegist) {
				$ar = [
					'regist_term'	=> $term,
					'regist_year'	=> $year,
					'regist_start'	=> $regist_start,
					'regist_stop'	=> $regist_stop,
					'dept_start'	=> $dept_start,
					'dept_stop'		=> $dept_stop,
				];
				$this->PrepareModel->insertData('regist', $ar);
				redirect('admin');
			} else {
				echo '<script>alert("มีรอบการทำงานนี้แล้ว");window.location="'.site_url('admin').'";</script>';
			}
		} else {
			echo '<script>alert("เกิดข้อผิดพลาด");window.location="'.site_url('admin').'";</script>';
		}
	}
	public function addRound() {
		if($this->input->post()) {echo 1;
			$round_id = $this->input->post('round_id');echo $round_id;
			$arEx = explode('/', $round_id);
			if(count($arEx) > 1) {echo 2;
				$regist = $this->AdminModel->loadRoundRegistTermYear($arEx[0], $arEx[1]);print_r($regist);
				$ar = [
					'regist_id' => $regist[0]['regist_id'],
					'round_num' => ($regist[0]['round_num'] != null ? $regist[0]['round_num'] + 1 : 1),
				];
				$round_id = $this->PrepareModel->insertData('round', $ar);
			}
			$this->AdminModel->addRound($this->input->post('student_id'), $this->input->post('working_stop'), $round_id);
		}
		redirect('admin/working/'.$this->input->post('dept_id').'/'.$this->input->post('student_id'));
	}

	public function addDept() {
		print_r($this->input->post());
		if($this->input->post()){
			$job_id				= $this->input->post('job_id');
			$dept_description	= $this->input->post('dept_description');
			$dept_property		= $this->input->post('dept_property');
			$dept_time			= $this->input->post('dept_time');
			$dept_gender		= $this->input->post('dept_gender');
			$dept_tel			= $this->input->post('dept_tel');
			$dept_status		= $this->input->post('dept_status');
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
				// $this->PrepareModel->insertData('dept', $ar);
			$dept_id = $this->PrepareModel->insertData('dept', $ar);
			$this->PrepareModel->deleteData('profile', 'username', $this->session->userdata('username'));
			$ar = [
				'username'	=> $this->session->userdata('username'),
				'name'		=> $this->session->userdata('name'),
				'name_en'	=> $this->session->userdata('name_en'),
				'div_id'	=> $this->session->userdata('dept_id'),
				'div_name'	=> $this->session->userdata('dept_name'),
				'gender'	=> $this->session->userdata('gender'),
			];
			$this->PrepareModel->insertData('profile', $ar);
		}
		// redirect('dept/'.($dept_status == 1 ? '' : 'depts')); 
		redirect('admin/students/'.$dept_id); 
	}

	public function addStudentS(){
		$dept_id = $this->input->post('dept_id');
		$student_id = $this->input->post('student_id');
		$checkDept = $this->AdminModel->checkDeptStudent($dept_id, $student_id);
		
		if(count($checkDept) > 0 ){
			echo '<script>alert("มีนักศึกษาในหน่วยงานพิเศษนี้แล้ว");window.location="'.site_url('admin/students/'.$dept_id).'";</script>';
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
			redirect('admin/students/'.$dept_id);
		}
	}

	public function loadDeptid(){
		echo json_encode($this->AdminModel->loadDeptid($this->input->post('dept_id')));
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
			redirect('admin');
		}
	}

	public function deleteDept($dept_id, $dept_admin){
		$checkDept = $this->AdminModel->checkDept($dept_id, $dept_admin);
		count($checkDept) > 0 ?: redirect('admin');

		$student = $this->PrepareModel->loadDataid('student', 'dept_id', $dept_id);
		if(count($student) > 0) {
			echo '<script>alert("มีนักศึกษาในหน่วยงานนี้แล้ว");window.location="'.site_url('admin').'";</script>';
		} else {
			$this->PrepareModel->deleteData('dept', 'dept_id', $dept_id);
			redirect('admin');
		}
	}

	public function updateWorking($dept_id, $student_id, $working_id, $working_status){
		$checkDept = $this->AdminModel->checkDeptStudent($dept_id, $student_id);
		count($checkDept) > 0 ?: redirect('admin');
		$ar = [
			'working_status'		=> $working_status,
		];
		$this->PrepareModel->updateData('working', 'working_id', $working_id, $ar);
		redirect('admin/working/'.$dept_id.'/'.$student_id);
	}

	public function deleteStudentS($dept_id, $student_id){
		$this->session->userdata('level') == 0 ?: redirect('admin');
		$checkStudent = $this->AdminModel->checkStudent($dept_id, $student_id);
		count($checkStudent) > 0 ?: redirect('dept');

		$working = $this->AdminModel->loadWorkingDeptStudent($dept_id, $student_id);
		if(count($working) > 0) {
			echo '<script>alert("นักศึกษามีชั่วโมงทำงานในหน่วยงานนี้แล้ว");window.location="'.site_url('admin/students/'.$dept_id).'";</script>';
		} else {
			$this->AdminModel->deleteStudentDept($dept_id, $student_id);
			redirect('admin/students/'.$dept_id);
		}
	}

	public function tranfer() {
		// print_r($this->input->post());
		if($this->input->post()) {
			$regist_id	= $this->input->post('regist_id');
			$date		= strtotime($this->input->post('date'));
			$no			= $this->input->post('no');
			$student_id	= $this->input->post('student_id');
			$director	= $this->input->post('director');
			$name		= $this->input->post('name');
			$position	= $this->input->post('position');

			$regist		= $this->PrepareModel->loadDataid('regist', 'regist_id', $regist_id);
			$m			= ['มกราคม' , 'กุมภาพันธ์' , 'มีนาคม' , 'เมษายน' , 'พฤษภาคม' , 'มิถุนายน' , 'กรกฎาคม' , 'สิงหาคม' , 'กันยายน' , 'ตุลาคม' , 'พฤศจิกายน' , 'ธันวาคม'];
			require_once('assets/lib/tcpdf/tcpdf.php');
			// Print PDF
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor(site_url());
			$pdf->SetTitle('ใบส่งตัว');

			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->SetMargins(25, 20, 25);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->SetFont('thsarabunnew', '', 16, '', true);
			$pdf->SetAlpha(1);

			$h = '<table>
			<tr>
				<td rowspan="2"><img src="'.site_url('assets/img/logo/psu.jpg').'" width="35"/></td>
				<td colspan="2"></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;font-size: 30px;"><b>บันทึกข้อความ</b></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2" width="70%"><b>ส่วนงาน</b> งานแนะแนวและจัดหางาน กองกิจการนักศึกษา</td>
				<td>โทร.2204</td>

			</tr>
			<tr>
				<td width="50%"><b>ที่</b> มอ 052/'.$no.'</td>
				<td colspan="2">วันที่ '.date('j', $date).' '.$m[date('n', $date) - 1].' '.(date('Y', $date) + 543).'</td>
			</tr>
			<tr>
				<td colspan="3"><b>เรื่อง</b> ส่งตัวนักศึกษาทุนทำงานแลกเปลี่ยน ประจำภาคการศึกษาที่ '.$regist[0]['regist_term'].'/'.($regist[0]['regist_year'] + 543).'</td>
			</tr></table><hr/><br/>';
			
			$c1 = 'ตามที่ กองกิจการนักศึกษาได้จัดให้มีทุนช่วยเหลือนักศึกษาประเภททุนทำงานแลกเปลี่ยนเป็นประจำทุกภาคการศึกษาและท่านได้แจ้งความจำนงขอนักศึกษาทุนทำงานแลกเปลี่ยนไปช่วยปฏิบัติงานยังหน่วยงานของท่านประจำภาคการศึกษาที่2/2562 นั้น';
			$c21 = 'ในการนี้ กองกิจการนักศึกษาขอส่งตัว';
			$c22 = 'เพื่อปฏิบัติงานกับท่านพร้อมนี้ได้แนบคู่มือการใช้งานเว็บไซต์ <u>student.psu.ac.th/fundjob</u> จำนวน 1 ชุด มาด้วย ภายหลังจากนักศึกษาได้ปฏิบัติงานสิ้นสุด ขอให้หน่วยงานช่วยตรวจสอบชั่วโมงการปฏิบัติงาน จากใบลงเวลาที่นักศึกษากรอกในเว็บไซต์ให้ถูกต้องและทำการอนุมัติผ่านระบบเว็บไซต์ดังกล่าว แล้วให้นักศึกษานำใบลงเวลาส่งที่กองกิจการนักศึกษา';
			$c3 = 'จึงเรียนมาเพื่อโปรดทราบ และพิจารณาดำเนินการต่อไปด้วย จักเป็นพระคุณยิ่ง';

			// $c1 = '<p style="text-indent: 25em;">
			// 	ตามที่ กองกิจการนักศึกษา ได้จัดให้มีทุนช่วยเหลือนักศึกษาประเภททุนทำงานแลกเปลี่ยนเป็นประจำทุกภาคการศึกษา และท่านได้แจ้งความจำนงขอนักศึกษาทุนทำงานแลกเปลี่ยนไปช่วยปฏิบัติงานยังหน่วยงานของท่าน ประจำภาคการศึกษาที่ 2/2562 นั้น
			// </p>';
			// $c2 = '<p style="text-indent: 25em;">
			// 	ในการนี้ กองกิจการนักศึกษาขอส่งตัว ';
			// 	$c3 = 'เพื่อปฏิบัติงานกับท่าน พร้อมนี้ได้แนบคู่มือการใช้งานเว็บไซต์ <u>student.psu.ac.th/fundjob</u> จำนวน 1 ชุด มาด้วย ภายหลังจากนักศึกษาได้ปฏิบัติงานสิ้นสุด ขอให้หน่วยงานช่วยตรวจสอบชั่วโมงการปฏิบัติงาน จากใบลงเวลาที่นักศึกษากรอกในเว็บไซต์ให้ถูกต้องและทำการอนุมัติผ่านระบบเว็บไซต์ดังกล่าว แล้วให้นักศึกษานำใบลงเวลาส่งที่กองกิจการนักศึกษา
			// </p>
			// <p style="text-indent: 25em;">
			// 	จึงเรียนมาเพื่อโปรดทราบ และพิจารณาดำเนินการต่อไปด้วย จักเป็นพระคุณยิ่ง
			// </p>';

			$footer = '<table style="text-align: center;">
			<tr>
				<td width="40%"></td>
				<td width="45%">';
			
			if($director != '') {
				$footer .= '<img src="'.site_url('assets/img/sign.png').'" width="55"/>';
				$footer .= '<br/>(นายคมกริช ชนะศรี)<br>ผู้อำนวยการกองกิจการนักศึกษา';
			} else {
				$footer .= '<br/><br/><br/><br/>('.$name.')<br>'.$position;
			}
			$footer .= '</td><td></td></tr></table>';

			$student = $this->AdminModel->loadStudentWoring($regist_id, ($student_id == 1 ? false : $student_id));
			foreach($student AS $r) {
				$d = 'เรียน คุณ'.$r['dname'].' '.$r['ddiv_name'];
				$s = '<b> '.$r['sname'].' รหัสนักศึกษา '.$r['student_id'].' นักศึกษาชั้นปีที่ 2 '.$r['sdiv_name'].' </b> ';
				$c = "<table>
					<tr>
						<td>{$d}</td>
					</tr>
					<tr>
						<td><p style=\"text-indent: 25em; text-justify:auto;\">{$c1}</p></td>
					</tr>
					<tr>
						<td><p style=\"text-indent: 25em; text-justify:auto;\">{$c21}{$s}{$c22}</p></td>
					</tr>
					<tr>
						<td><p style=\"text-indent: 25em; text-justify:auto;\">{$c3}</p></td>
					</tr>
					<tr>
						<td></td>
					</tr>
				</table>";

				$pdf->AddPage();
				$pdf->writeHtml($h.$c.$footer);
			}
			// foreach($student AS $r) {
			// 	$d = 'เรียน คุณ'.$r['dname'].' '.$r['ddiv_name'];
			// 	$s = '<b> '.$r['sname'].' รหัสนักศึกษา '.$r['student_id'].' นักศึกษาชั้นปีที่ 2 '.$r['sdiv_name'].' </b> ';
			// 	$pdf->AddPage();
			// 	$pdf->writeHtml($h.$d.$c1.$c2.$s.$c3.$footer);
			// }
			
			$fileName = 'tranfer_'.$regist[0]['regist_term'].'-'.($regist[0]['regist_year'] + 543).($student_id == 1 ? '' : '_'.$student_id);
			$pdf->Output("{$fileName}.pdf", 'I');


		}
	}
}
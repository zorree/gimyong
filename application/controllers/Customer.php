<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
	public function __construct() {
		parent::__construct();
		header("Cache-Control: public, max-age=60, s-maxage=60");
		$this->load->model('CustomerModel');
		$this->session->userdata('type') == 'customer' ?: redirect();
	}
	public function index() {
		$data['content'] = 'customer/index';
		$this->load->view('include/layout', $data);
	}

	//MARKET ZONE

	public function profile() {
		$data['customerdetail'] = $this->CustomerModel->customerdetail();
		// $data['scoredetail'] 	= $this->CustomerModel->scoredetail();
		// print_r($data);
		// $data['goods'] = $this->AdminModel->goods($id);
		$data['content'] = 'customer/profile';
		$this->load->view('include/layout', $data);
	}

	public function showmarket() {
		if ($this->input->post('data')){
			$x = $this->CustomerModel->loadmarketsearch($this->input->post('data'));
		} else {
			$x = $this->CustomerModel->loadmarket();
		}
		echo json_encode($x);
	}

	public function editprofile() {
		// print_r($this->input->post());
		// print_r($_FILES['picture']['name']);
		if($this->input->post()){
			if($_FILES['picture']['name']){
				$img = $this->CustomerModel->loadcimg();
				if($img[0]['c_img']){
					$path_to_file = 'assets/img/customer/'.$img[0]['c_img'];
					unlink($path_to_file);
				}
				$filename	= time().'-U-'.$this->session->userdata('id');
				$config['upload_path']		= 'assets/img/customer';
				$config['allowed_types']	= 'gif|jpg|png';
				$config['file_name']		= $filename;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('picture')) {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
						// $this->load->view('upload_form', $error);
				} else {
					$data = array('upload_data' => $this->upload->data());
					// print_r($data['upload_data']['orig_name']);
					// $this->load->view('upload_success', $data);
					$ar1 = ['c_img'	=> $data['upload_data']['orig_name']];
					$this->PrepareModel->updateData('customer', 'c_id', $this->session->userdata('id'), $ar1);
				}
			}

			$cname			= $this->input->post('cname');
			$clname			= $this->input->post('clname');
			$ar = [
				'c_name'			=> $cname,
				'c_lname'			=> $clname,
			];
			$this->PrepareModel->updateData('customer', 'c_id', $this->session->userdata('id') , $ar);
			echo '<script>alert("แก้ไขข้อมูลสำเร็จ");window.location="'.site_url("customer/profile").'";</script>';
		
		}	
	}

	public function market() {
		$data['listmarket']	= $this->CustomerModel->loadmarket();
		$data['content']	= 'customer/market';
		$this->load->view('include/layout', $data);
	}

	public function marketdetail($id) {
		$data['customerdetail'] = $this->CustomerModel->customerdetail();
		$data['marketdetail'] 	= $this->CustomerModel->marketdetail($id);
		$data['Rgoods'] 		= $this->CustomerModel->Rgoods($id);
		$data['report'] 		= $this->CustomerModel->report($id);
		$data['id'] 			= $id;
		$data['content'] 		= 'customer/marketdetail';
		$this->load->view('include/layout', $data);
	}

	public function gooddetail($id) { 
		$data['Rgoods'] 		= $this->CustomerModel->Rgoods($id);
		$data['goods'] 			= $this->CustomerModel->goods($id);
		$data['content']		= 'goods';
		$this->load->view('include/layout', $data);
	}

	public function report() { 
		$data['report'] 		= $this->CustomerModel->loadreport();
		// print_r($data);
		$data['content']		= 'customer/report';
		$this->load->view('include/layout', $data);
	}

	public function showreport($id) { 
		$data['report'] 		= $this->CustomerModel->showreport($id);
		echo json_encode($data);		
	}

	public function editreport() {
		if($this->input->post()){
			$ar = [
				'r_comment'			=> $this->input->post('comment'),
			];
			$this->PrepareModel->updateData('report', 'r_id', $this->input->post('id') , $ar);
			echo '<script>alert("แก้ไขข้อมูลสำเร็จ");window.location="'.site_url("customer/report").'";</script>';
		}
	}

	public function deletereport() { 
		print_r($this->input->post());
		if($this->input->post()){
			$this->PrepareModel->deleteData('report', 'r_id', $this->input->post('submit'));
			echo '<script>alert("ลบข้อมูลสำเร็จ");window.location="'.site_url("customer/report").'";</script>';
		}
	}
	

	
		

	public function addreport() { 
		// print_r($this->input->post());
		if($this->input->post()){
			$ar = [
				'r_comment'		=> $this->input->post('comment'),
				'c_id'			=> $this->session->userdata('id'),
				'm_id'			=> $this->input->post('m_id')
			];
			$this->PrepareModel->insertData('report', $ar);	
			echo '<script>alert("เพิ่มความเห็นสำเร็จ");window.location="'.site_url("customer/marketdetail/{$this->input->post('m_id')}").'";</script>';
		}
	}



	public function marketedit() {
		if($this->input->post()){
			$id = $this->input->post('id');
			$data['marketdetail'] = $this->AdminModel->marketdetail($id);
			$data['goods'] = $this->AdminModel->goods($id);
			$data['content'] = 'admin/marketedit';
			$this->load->view('include/layout', $data);
		}else{
			$id = $this->input->post('id');
			redirect('admin/marketedit',$id);
		}
		
	}

	//CUSTOMER ZONE

	public function customer() {
		// $data['listRegist'] = $this->AdminModel->loadRegist();
		// $data['listStudentS'] = $this->AdminModel->loadStudentS();
		$data['content'] = 'admin/customer';
		$this->load->view('include/layout', $data);
	}

	public function customerdetail() {
		// $data['listRegist'] = $this->AdminModel->loadRegist();
		// $data['listStudentS'] = $this->AdminModel->loadStudentS();
		$data['content'] = 'admin/customerdetail';
		$this->load->view('include/layout', $data);
	}

	//PROMOTION ZONE

	public function promotion() {
		// $data['listRegist'] = $this->AdminModel->loadRegist();
		// $data['listStudentS'] = $this->AdminModel->loadStudentS();
		$data['content'] = 'admin/promotion';
		$this->load->view('include/layout', $data);
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct() {
		parent::__construct();
		header("Cache-Control: public, max-age=60, s-maxage=60");
		$this->load->model('AdminModel');
		// $this->session->userdata('type') == 'admin' && $this->session->userdata('level') == 1 ?: redirect('index/login/admin');
	}
	
	public function index() {
		// print_r($this->session->userdata());
		if ($this->session->userdata('type') != 'admin') {
			$this->session->sess_destroy();
		} 
		if ($this->session->userdata('type') == 'admin') {
			redirect();
		} 
		$this->load->view('admin/login');
	}

	public function login()	{
		// print_r($this->input->post());
		if ($this->input->post()){
			$user		= $this->input->post('username');
			$pass		= $this->input->post('password');
			$usercheck	= $this->AdminModel->loadUser('admin', 'a_user', $user, 'a_pass', $pass);
			if ($usercheck)	{
				$sess['id']			= $usercheck[0]['a_id'];
				$sess['user']		= $usercheck[0]['a_user'];
				$sess['name']		= "{$usercheck[0]['a_name']} {$usercheck[0]['a_lname']}";
				// $sess['level']		= $usercheck[0]['a_level'];
				$sess['type']		= 'admin';
				$sess['login']		= true;
				$this->session->set_userdata($sess);
				redirect('admin/market');
				// redirect('admin/profile');
				// echo ('usercheck OK');
			} else {
				echo ('usercheck Error');
			}
			// print_r($usercheck);

		} else {
			echo ('massege error');
		}
	}

	//MARKET ZONE

	public function market() {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		$data['num']				= 0;
		$data['listmarket']			= $this->AdminModel->loadmarket();
		$data['countlistmarket']	= count($data['listmarket']);
		$data['content']			= 'admin/market';
		$this->load->view('include/layout', $data);
	}

	public function showmarket() {
		if ($this->input->post('data')){
			$x = $this->AdminModel->loadmarketsearch($this->input->post('data'));
		} else {
			$x = $this->AdminModel->loadmarket();
		}
		echo json_encode($x);
	}

	public function marketdetail($id) {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
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
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
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
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		// print_r($this->input->post());
		// print_r($_FILES);
		if($this->input->post()){
			$m_id	= $this->input->post('m_id');
			if ($_FILES['picture']['name']) {
				$img = $this->AdminModel->loadmarketimguser($m_id);
				$user = $img[0]['m_user'];
				print_r($user);
				if ($img[0]['m_img']) {
					$path_to_file = 'assets/img/market/'.$img[0]['m_img'];
					unlink($path_to_file);
				}
				$filename	= time().'-U-'.$user;
				$config['upload_path']		= 'assets/img/market';
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
					$ar1 = ['m_img'	=> $data['upload_data']['orig_name']];
					$this->PrepareModel->updateData('market', 'm_id', $m_id, $ar1);
				}
			}
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
		}
	}

	public function showgoods($id) {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		echo json_encode($this->PrepareModel->loadDataid('goods', 'g_id', $id));
	}

	//CUSTOMER ZONE

	public function customer() {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		$data['listcustomer'] = $this->AdminModel->loadcustomer();
		$data['content'] = 'admin/customer';
		$this->load->view('include/layout', $data);
	}
	
	public function showcustomer() {
		if ($this->input->post('data')){
			$x = $this->AdminModel->loadcustomersearch($this->input->post('data'));
		} else {
			$x = $this->AdminModel->loadcustomer();
		}
		echo json_encode($x);
	}

	public function customerdetail($id) {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		if($id != null){
			$data['customerdetail'] = $this->AdminModel->customerdetail($id);
			// $data['scoredetail'] 	= $this->AdminModel->scoredetail($id);
			$data['content'] = 'admin/customerdetail';
			$this->load->view('include/layout', $data);
		}else{
			redirect('admin/market');
		}
	}

	public function customeredit() {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		if($this->input->post()){
			$id = $this->input->post('c_id');
			$data['customerdetail'] = $this->AdminModel->customeredit($id);
			$data['content'] = 'admin/customeredit';
			$this->load->view('include/layout', $data);
		}else{
			redirect('admin/market');
		}
	}

	public function editcustomer() {
		// print_r($this->input->post());
		// print_r($_FILES);
		if($this->input->post()){
			$cid = $this->input->post('cid');
			if($_FILES['picture']['name']){
				$img = $this->AdminModel->loadcimg($cid);
				// print_r($img);
				if($img[0]['c_img']){
					$path_to_file = 'assets/img/customer/'.$img[0]['c_img'];
					unlink($path_to_file);
				}
				$filename	= time().'-U-'.$this->session->userdata('user');
				$config['upload_path']		= 'assets/img/customer';
				$config['allowed_types']	= 'gif|jpg|png';
				$config['file_name']		= $filename;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('picture')) {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				} else {
					$data = array('upload_data' => $this->upload->data());
					$ar1 = ['c_img'	=> $data['upload_data']['orig_name']];
					$this->PrepareModel->updateData('customer', 'c_id', $cid, $ar1);
				}
			}

			$cname			= $this->input->post('cname');
			$clname			= $this->input->post('clname');
			$ar = [
				'c_name'			=> $cname,
				'c_lname'			=> $clname,
			];
			$this->PrepareModel->updateData('customer', 'c_id', $cid , $ar);
			echo '<script>alert("แก้ไขข้อมูลสำเร็จ");window.location="'.site_url("admin/customerdetail/$cid").'";</script>';
		
		}	
	}


	//PROMOTION ZONE

	public function promotion() {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		$data['listpromotion'] = $this->AdminModel->loadpromotion();
		$data['content'] = 'admin/promotion';
		$this->load->view('include/layout', $data);
	}

	//GOODS ZONE

	public function goodsdetail($id){
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		if($id != null){
			$data['customerdetail'] = $this->AdminModel->customeredit($id);
			$data['content'] = 'admin/goodsdetail';
			$this->load->view('include/layout', $data);
		}else{
			redirect('admin/market');
		}
	}

	public function addgoods() {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		// print_r($this->input->post());
		// print_r($_FILES['picture']);
		if ($_FILES['picture']['type'] == 'image/jpeg'  ||  $_FILES['picture']['type'] == 'image/png') {
			if ($this->input->post()) {
				$m_id = $this->input->post('m_id');
				$filename	= time().'-U-'.$this->session->userdata('user');
				$config['upload_path']		= 'assets/img/goods';
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
					$ar = [
						'g_name'	=> $this->input->post('g_name'),
						'g_price'	=> $this->input->post('g_price'),
						'g_img'		=> $data['upload_data']['orig_name'],
						'm_id'		=> $m_id,
					];
					$this->PrepareModel->insertData('goods', $ar);
					echo '<script>alert("อัปโหลดสำเร็จ");window.location="'.site_url("admin/marketdetail/{$m_id}").'";</script>';
				}
			}
		} else {
			echo '<script>alert("ไม่ใช่ไฟล์ที่กำหนดไว้ ต้องเป็น .png หรือ .jpg เท่านั้น");window.location="'.site_url("admin/marketdetail/{$m_id}").'";</script>';
		}
	}

	public function deletegoods() {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		// print_r($this->input->post());
		if ($this->input->post()) {
			$m_id = $this->input->post('m_id');
			$this->AdminModel->deletegoods($this->input->post('submit'));
			$path_to_file = 'assets/img/goods/'.$this->input->post('g_img');
			if(unlink($path_to_file)) {
				// echo 'deleted successfully';
				echo '<script>alert("ลบสินค้านี้แล้ว");window.location="'.site_url("admin/marketdetail/{$m_id}").'";</script>';
			}
			else {
				echo 'errors occured';
			}
		}
	}

	public function editgoods() {
		$this->session->userdata('type') == 'admin' ?: redirect('admin');
		// print_r($this->input->post());
		// print_r($_FILES);
		if ($this->input->post()) {
			$g_id	= $this->input->post('g_id');
			$m_id	= $this->input->post('m_id');
			if ($_FILES['picture1']['name']) {
				$img = $this->AdminModel->loadgoodsimg($g_id);
				if ($img[0]['g_img']) {
					$path_to_file = 'assets/img/goods/'.$img[0]['g_img'];
					unlink($path_to_file);
				}

				$filename	= time().'-U-'.$this->session->userdata('user');
				$config['upload_path']		= 'assets/img/goods';
				$config['allowed_types']	= 'gif|jpg|png';
				$config['file_name']		= $filename;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('picture1')) {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
						// $this->load->view('upload_form', $error);
				} else {
					$data = array('upload_data' => $this->upload->data());
					// print_r($data['upload_data']['orig_name']);
					// $this->load->view('upload_success', $data);
					$ar1 = ['g_img'	=> $data['upload_data']['orig_name']];
					$this->PrepareModel->updateData('goods', 'g_id', $g_id, $ar1);
				}
			}

			$ar = [
				'g_name'	=> $this->input->post('g_name'),
				'g_price'	=> $this->input->post('g_price'),
			];
			$this->PrepareModel->updateData('goods', 'g_id', $g_id, $ar);
			echo '<script>alert("แก้ไขสำเร็จ");window.location="'.site_url("admin/marketdetail/{$m_id}").'";</script>';
		}
	}
}
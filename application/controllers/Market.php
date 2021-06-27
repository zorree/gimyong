<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('MarketModel');
		$this->session->userdata('type') == 'market' ?: redirect();
	}
	public function index() {
		$level = $this->session->userdata('level');
		if ($level == 0 || $level == 1) {
			redirect('market/profile');
		} else {
			redirect();
		}
	}

	//MARKET ZONE

	public function profile() {
		$data['marketdetail']	= $this->MarketModel->loadmarket();
		if ($data['marketdetail'][0]['m_level'] == 0) {
			$data['content']		= 'market/profile';
			$this->load->view('include/layout', $data);
			// echo ('update pofile');
		} else if ($data['marketdetail'][0]['m_level'] == 1) {
			echo ('wait admin');
		} else if ($data['marketdetail'][0]['m_level'] == 2) {
			$data['content']	= 'market/profile';
			$this->load->view('include/layout', $data);
		}
		else {
			echo ('no data');
		}
		// $data['goods']			= $this->MarketModel->goods();
		// $data['content']		= 'market/profile';
		// $this->load->view('include/layout', $data);
	}

	public function goods() {
		$data['goods']		= $this->MarketModel->loadgoods();
		$data['Rgoods']		= $this->MarketModel->loadRgoods();
		$data['content']	= 'market/goods';
		$this->load->view('include/layout', $data);
	}

	public function addRgoods() {
		$ar = [
			'g_level' => 1
		];
		$this->PrepareModel->updateData('goods', 'g_id', $this->input->post('data') , $ar);
		$data['goods']		= $this->MarketModel->loadgoods();
		$data['Rgoods']		= $this->MarketModel->loadRgoods();
		echo json_encode($data);
	}

	public function daleteRgoods() {
		$ar = [
			'g_level' => 0
		];
		$this->PrepareModel->updateData('goods', 'g_id', $this->input->post('data') , $ar);
		$data['goods']		= $this->MarketModel->loadgoods();
		$data['Rgoods']		= $this->MarketModel->loadRgoods();
		echo json_encode($data);
	}

	public function marketedit() {
		$data['marketdetail']	= $this->MarketModel->loadmarket();
		$data['content']		= 'market/marketedit';
		$this->load->view('include/layout', $data);
	}

	public function report() {
		$data['report']	= $this->MarketModel->loadreport();
		$data['content']		= 'market/report';
		$this->load->view('include/layout', $data);
	}

	public function marketeditaction() {
		if($this->input->post()){

			// print_r($_FILES['picture']['name']);

			if ($_FILES['picture']['name']) {
				$img = $this->MarketModel->loadmarketimg();
				// echo $img[0]['m_img'];
				if ($img[0]['m_img']) {
					$path_to_file = 'assets/img/market/'.$img[0]['m_img'];
					unlink($path_to_file);
				}
				$filename	= time().'-U-'.$this->session->userdata('id');
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
					print_r($data['upload_data']['orig_name']);
					// $this->load->view('upload_success', $data);
					$ar1 = ['m_img'	=> $data['upload_data']['orig_name']];
					$this->PrepareModel->updateData('market', 'm_id', $this->session->userdata('id'), $ar1);
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
			echo '<script>alert("แก้ไขข้อมูลสำเร็จ");window.location="'.site_url("market/profile/{$m_id}").'";</script>';
		}

	}

	public function addgoods() {
		// print_r($this->input->post());
		// print_r($_FILES['picture']['type']);
		if ($_FILES['picture']['type'] == 'image/jpeg'  ||  $_FILES['picture']['type'] == 'image/png') {
			if ($this->input->post()) {
				$filename	= time().'-U-'.$this->session->userdata('id');
				$config['upload_path']		= 'assets/img/goods';
				$config['allowed_types']	= 'gif|jpg|png';
				// $config['max_size']			= '1024';
				// $config['max_width']		= '1024';
				// $config['max_height']		= '768';
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
						'g_name'	=> $this->input->post('goodsname'),
						'g_price'	=> $this->input->post('goodsprice'),
						'g_img'		=> $data['upload_data']['orig_name'],
						'm_id'		=> $this->session->userdata('id'),
					];
					$this->PrepareModel->insertData('goods', $ar);
					echo '<script>alert("อัปโหลดสำเร็จ");window.location="'.site_url("market/goods").'";</script>';
				}
			}
		} else {
			echo '<script>alert("ไม่ใช่ไฟล์ที่กำหนดไว้ ต้องเป็น .png หรือ .jpg เท่านั้น");window.location="'.site_url("market/goods").'";</script>';
		}
	}

	public function deletegoods() {
		// print_r($this->input->post());
		if ($this->input->post()) {
			$this->MarketModel->deletegoods($this->input->post('submit'));
			$path_to_file = 'assets/img/goods/'.$this->input->post('submit');
			if(unlink($path_to_file)) {
				// echo 'deleted successfully';
				echo '<script>alert("ลบสินค้านี้แล้ว");window.location="'.site_url("market/goods").'";</script>';
			}
			else {
				echo 'errors occured';
			}
		}
	}

	public function editgoods() {
		// print_r($this->input->post());
		// print_r($_FILES);
		if ($this->input->post()) {
			$g_id	= $this->input->post('id');

			if ($_FILES['picture1']['name']) {
				$img = $this->MarketModel->loadgoodsimg($this->input->post('id'));
				if ($img[0]['g_img']) {
					$path_to_file = 'assets/img/goods/'.$img[0]['g_img'];
					unlink($path_to_file);
				}

				$filename	= time().'-U-'.$this->session->userdata('id');
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
				'g_name'	=> $this->input->post('goodsname'),
				'g_price'	=> $this->input->post('goodsprice'),
			];
			$this->PrepareModel->updateData('goods', 'g_id', $g_id, $ar);
			echo '<script>alert("แก้ไขสำเร็จ");window.location="'.site_url("market/goods").'";</script>';
		}
	}

	public function showgoods($id) {
		echo json_encode($this->PrepareModel->loadDataid('goods', 'g_id', $id));
	}







	public function promotion() {
		$data['listpromotion'] 		= $this->MarketModel->loadpromotion();
		$data['addPromotion']		= $this->MarketModel->addPromotion();
		// print_r($data['addPromotion']);
		$data['content'] = 'market/promotion';
		$this->load->view('include/layout', $data);
		// print_r($data);
	}

	public function addPromotion() {
		// print_r($this->input->post('g_name'));
		$data = $this->MarketModel->loadgoodsidname($this->input->post('g_name'));

		$ar = [
			'p_price'			=> $this->input->post('p_price'),
			'p_timestart'		=> $this->input->post('p_timestart'),
			'p_timesend'		=> $this->input->post('p_timesend'),
			'g_id'				=> $data[0]['g_id'],
			'm_id'				=> $this->session->userdata('m_id'),
		];
		$this->PrepareModel->insertData('promotion', $ar);

		$pronows = $this->MarketModel->loadpromotionid($data[0]['g_id']);
		// print_r($pronows);

		$update = [
			'p_id'	=> $pronows[0]['p_id'],
		];
		$updetegoods = $this->PrepareModel->updateData('goods', 'g_id', $data[0]['g_id'] , $update);

		// $this->PrepareModel->updateData('regist', 'p_id', $promotion[0]['p_id'] , $update);

		redirect('market/promotion');

		
		// print_r($data[0]['g_detail']);
		// $this->MarketModel->loadpromotion();
		// redirect('market/promotion');
	}

	public function marketdetail() {
		if($this->input->post()){
			$id = $this->session->userdata('id');
			$data['marketdetail'] = $this->AdminModel->marketdetail($id);
			$data['goods'] = $this->AdminModel->goods($id);
			$data['content'] = 'admin/marketdetail';
			$this->load->view('include/layout', $data);
		}else{
			// $id = $this->input->post('id');
			redirect('admin/market');
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

}
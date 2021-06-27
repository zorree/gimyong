<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('IndexModel');
	}

	public function index() {
		// $data['shoptype']	= ["food", "dish", "wear"];
		$data['content']	= 'index';
		$data['marker']		= $this->IndexModel->loadMarker();
		$this->load->view('include/layout', $data);
		// $data = $this->IndexModel->loadMarker();
		// $myJSON = json_encode($data);
		// print_r($data['marker'][0]);
	}

	public function searchmarket() {
		$x = $this->IndexModel->loadDataMarkerSearch($this->input->post('data'));
		// print_r($x);
		// echo json_encode($x);
		echo json_encode($x);
	}
		

	public function encrypt() {
		// The unencrypted password to be hashed 
		$unencrypted_password = "Cloudways@123"; 
  
		// The hash of the password can be saved in the database
		$hash = password_hash($unencrypted_password, PASSWORD_DEFAULT); 
		
		// Print the generated hash code
		echo "Generated hash code: ".$hash; 

		$verify = password_verify($unencrypted_password, '$2y$10$RQuPUbswMji83Ix18ZA7s./4FtEV.sSTY3N1VNzEwVUsSic4RsPve'); 
		
		echo "<br>Generated hash code: ".$verify; 
	}

	public function addplaces($id) {
		echo json_encode($this->IndexModel->loadDataMarker($id));
	}

	public function login($login) {
		if ($login == 'customer'){
			$data['icon'] 	= 'fa-street-view';
			$data['submit'] = '2';
		} else if ($login == 'market'){
			$data['icon'] 	= 'fa-store';
			$data['submit'] = '1';
		} else {
			// redirect();
			echo '<script>alert("ท่านไม่ทำตามระบบ");window.location="'.site_url().'";</script>';
		}
		$this->load->view('login', $data);
	}

	public function loginCheck() {
		if($this->input->post()) {
			$user		= $this->input->post('username');
			$pass		= md5($this->input->post('password'));
			$level		= $this->input->post('submit');
			if ($level == 1) {
				//market
				$usercheck			= $this->IndexModel->loadUser('market', 'm_user', $user, 'm_pass', $pass);
				if ($usercheck != Array())	{
					$sess['id']			= $usercheck[0]['m_id'];
					$sess['user']		= $usercheck[0]['m_user'];
					$sess['name']		= "{$usercheck[0]['m_name']} {$usercheck[0]['m_lname']}";
					$sess['level']		= $usercheck[0]['m_level'];
					$sess['type']		= 'market';
					$sess['login']		= true;
					$this->session->set_userdata($sess);
					redirect('market/index');
				} else {
					echo '<script>alert("ชื่อผู้ใช้ หรือ รหัสผ่านของท่านไม่ถูกต้อง ");window.location="'.site_url('index/login/market').'";</script>';
				}
			} else if ($level == 2) {
				//customer
				$usercheck			= $this->IndexModel->loadUser('customer', 'c_user', $user, 'c_pass', $pass);
				if ($usercheck != Array()) {
					$sess['id']			= $usercheck[0]['c_id'];
					$sess['user']		= $usercheck[0]['c_user'];
					$sess['name']		= "{$usercheck[0]['c_name']} {$usercheck[0]['c_lname']}";
					$sess['type']		= 'customer';
					$sess['login']		= true;
					$this->session->set_userdata($sess);
					redirect();
				} else {
					echo '<script>alert("ชื่อผู้ใช้ หรือ รหัสผ่านของท่านไม่ถูกต้อง ");window.location="'.site_url('index/login/customer').'";</script>';
				}
			} else {
				echo '<script>alert("ท่านไม่ทำตามระบบ");window.location="'.site_url().'";</script>';
			} 
		} else {
			echo '<script>alert("ท่านไม่ทำตามระบบ");window.location="'.site_url().'";</script>';
		}
	}

	public function register() {
		$this->load->view('register');
	}

	public function userCheck($user) {
		if ($this->IndexModel->loadCUser($user) != Array ()){
			echo ("มีชื่อผู้ใช้งานนี้แล้ว");
		} else {
			echo ("");
		}
	}

	public function muserCheck($user) {
		if ($this->IndexModel->loadMUser($user) != Array ()){
			echo ("มีชื่อผู้ใช้งานนี้แล้ว");
		} else {
			echo ("");
		}
	}

	public function registerCheck() {
		// print_r($this->input->post());
		if ($this->input->post()) {
			$username	=	$this->input->post('username');
			$password	=	$this->input->post('password');
			// $firstname	=	$this->input->post('firstname');
			// $lastname	=	$this->input->post('lastname');
			$submit		=	$this->input->post('submit');
			if ($submit == 1) {
				// echo ("customer");
				$data	=	array(
					'c_user'	=>	$username,
					'c_pass'	=>	md5($password),
					'c_name'	=>	$this->input->post('cname'),
					'c_lname'	=>	$this->input->post('clname')
				);
				$this->IndexModel->addRegister('customer', $data);
				echo '<script>alert("ลงทะเบียนสำเร็จ");window.location="'.site_url().'";</script>';
			} else if ($submit == 2) {
				$mname			=	$this->input->post('mname');
				$mlname			=	$this->input->post('mlname');
				$mmarketname	=	$this->input->post('mmarketname');
				$mtype			=	$this->input->post('mtype');
				$mlong			=	$this->input->post('mlong');
				$mlat			=	$this->input->post('mlat');
				$data	=	array(
					'm_user'		=>	$username ,
					'm_pass'		=>	md5($password) ,
					'm_name'		=>	$mname ,
					'm_lname'		=>	$mlname ,
					'm_shopname'	=>	$mmarketname ,
					'm_shoptype'	=>	$mtype ,
					'm_lng'			=>	$mlong ,
					'm_lat'			=>	$mlat
				);
				$this->IndexModel->addRegister('market', $data);
				echo '<script>alert("ลงทะเบียนสำเร็จ");window.location="'.site_url().'";</script>';
			} else {
				echo ("NO data");
			}
		} else {
			echo ("No data");
		}	
	}

	public function marketdetial($id) {
		// print_r($this->input->post());
		if ($this->session->userdata('type') == 'customer') {
			redirect("customer/marketdetail/{$id}");
		}
		$data['id']				= $id;
		$data['marketdetail']	= $this->IndexModel->loadmarketid($id);
		$data['Rgoods'] 		= $this->IndexModel->Rgoods($id);
		$data['report'] 		= $this->IndexModel->report($id);
		$data['content']		= 'marketdetial';
		$this->load->view('include/layout', $data);
	}

	public function gooddetail($id) { 
		$data['Rgoods'] 		= $this->IndexModel->Rgoods($id);
		$data['goods'] 			= $this->IndexModel->goods($id);
		$data['content']		= 'goods';
		$this->load->view('include/layout', $data);
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect();
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('IndexModel');
	}

	public function index() {
		$data['content'] = 'index';
		$this->load->view('include/layout', $data);
	}

	public function login() {
		if($this->input->post()) {
			$user		= $this->input->post('username');
			$pass		= $this->input->post('password');
			$usercheck	= $this->IndexModel->loadUser($user);
			if ($usercheck != Array ()) {
				if($usercheck[0]['u_level'] == 1){
					$admin = $this->IndexModel->checkAdmin($usercheck[0]['u_id']);
					$sess['user']		= $user;
					$sess['name']		= "{$admin[0]['a_name']} {$admin[0]['a_lname']}";
					$sess['gender']		= 'M';
					$sess['level']		= $usercheck[0]['u_level'];
					$sess['type']		= 'admin';
					$sess['login']		= true;
					$this->session->set_userdata($sess);
					redirect();
				}
				else if($usercheck[0]['u_level'] == 2){
					$market = $this->IndexModel->checkMarket($usercheck[0]['u_id']);
					$sess['u_id']		= $market[0]['u_id'];
					$sess['m_id']		= $market[0]['m_id'];
					$sess['user']		= $user;
					$sess['name']		= "{$market[0]['m_name']} {$market[0]['m_lname']}";
					$sess['gender']		= 'M';
					$sess['level']		= $usercheck[0]['u_level'];
					$sess['type']		= 'market';
					$sess['login']		= true;
					$this->session->set_userdata($sess);
					redirect();
				}
				else if($usercheck[0]['u_level'] == 3){
					$customer = $this->IndexModel->checkCustomer($usercheck[0]['u_id']);
					$sess['u_id']		= $customer[0]['u_id'];
					$sess['c_id']		= $customer[0]['c_id'];
					$sess['name']		= "{$customer[0]['c_name']} {$customer[0]['c_lname']}";
					$sess['gender']		= 'M';
					$sess['level']		= $usercheck[0]['u_level'];
					$sess['type']		= 'customer';
					$sess['login']		= true;
					$this->session->set_userdata($sess);
					redirect();
				} else {
					echo '<script>alert("ชื่อผู้ใช้ หรือ รหัสผ่านของท่านไม่ถูกต้อง");window.location="'.site_url().'";</script>';
				}
			} else {
				echo '<script>alert("ชื่อผู้ใช้ หรือ รหัสผ่านของท่านไม่ถูกต้อง");window.location="'.site_url().'";</script>';
			}
		}
	}

	public function register() {
		$this->load->view('register');
	}

	public function userCheck($user) {
		if ($this->IndexModel->loadUser($user) != Array ()){
			echo ("มีชื่อผู้ใช้งานนี้แล้ว");
		} else {
			echo ("");
		}
	}

	public function registerCheck() {
		print_r($this->input->post());
		
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect();
	}

	// public function path() {
	// 	if ($this->session->userdata('type') == 'admin') {
	// 		if ($this->session->userdata('level') == 0) {
	// 			redirect('admin'); //admin
	// 		} else {
	// 			redirect('dept'); //depS, dept
	// 		}
	// 	} else {
	// 		redirect('student'); //student
	// 	}
	// }
	// public function editnews() {
	// 	$this->session->userdata('type') == 'admin' && $this->session->userdata('level') == 0 ?: redirect();
	// 	if($this->input->post()) {
	// 		$file = fopen('assets/file/news.html', 'w') or die("Unable to open file!");
	// 		fwrite($file, $this->input->post('news'));
	// 		fclose($file);
	// 		redirect();
	// 	}
	// 	$data['content'] = 'editnews';
	// 	$this->load->view('include/layout', $data);
	// }
	// public function loadFile() {
	// 	$dir = 'assets/file/upload';
	// 	$ignored = array('.', '..', '.svn', '.htaccess');

	// 	$files = array();
	// 	foreach (scandir($dir) as $f) {
	// 		if (in_array($f, $ignored)) continue;
	// 		$files[$f] = filemtime($dir . '/' . $f);
	// 	}

	// 	arsort($files);
	// 	$files = array_keys($files);

	// 	$files = array_map(function($v) {
	// 		return iconv('windows-874', 'UTF-8', $v);
	// 	}, $files);

	// 	echo json_encode($files);
	// }
	// public function uploadFile() {
	// 	if($_FILES) {
	// 		$filename = str_replace(' ', '_', $_FILES['file']['name']);
	// 		$directory = 'assets/file/upload/';
	// 		if(file_exists($directory.'/'.$filename)){
	// 			$filename = $this->rename($directory, $filename);
	// 		}
	// 		if(move_uploaded_file($_FILES['file']['tmp_name'], $directory.'/'.$filename)) {
	// 			echo $directory;
	// 		}else{
	// 			echo 0;
	// 		}
	// 	}
	// }
	// public function deleteFile() {
	// 	if(unlink('assets/file/upload/'.iconv('utf-8', 'tis-620', $this->input->post('name')))) {
	// 		echo 1;
	// 	} else {
	// 		echo 0;
	// 	}
	// }
	// public function rename($directory, $filename){
	// 	$basename = pathinfo($filename, PATHINFO_FILENAME);
	// 	$extension = pathinfo($filename, PATHINFO_EXTENSION);
	// 	$i = 1;
	// 	do {
	// 		$newname = $basename.'_'.$i++.'.'.$extension;
	// 	} while(
	// 		file_exists($directory.'/'.$newname)
	// 	);
	// 	return $newname;
	// }
	// public function login() {
	// 	if($this->input->post()) {
	// 		$username	= $this->input->post('username');
	// 		$password	= $this->input->post('password');

	// 		if ($username != '') {
	// 			$sess['username']	= $username;
	// 			$sess['name']		= "{$username} นามสกุล";
	// 			$sess['name_en']	= 'FName Sname';
	// 			$sess['gender']		= 'M';
	// 			$sess['dept_id']	= '006';
	// 			$sess['dept_name']	= 'กองกิจการนักศึกษา สำนักงานอธิการบดี';
	// 			$sess['type']		= 'admin';
	// 			$sess['login']		= true;

	// 			$admin = $this->IndexModel->loadAdmin($username);
	// 			if(count($admin)) {
	// 				$sess['fac']	= '01';
	// 				$sess['level']	= $admin[0]['admin_level'];
	// 				$sess['dev']	= $admin[0]['level_id'] === 0 ? true : false;
	// 				$this->session->set_userdata($sess);

	// 			} else {
	// 				$dept	= str_replace('dept', '', $username);
	// 				if(is_numeric($username) && $username > 6000 && $username < 6100) {
	// 					$sess['name']		= "นาย{$username} นามสกุล";
	// 					$sess['fac']	= substr($username, 2, 2);
	// 					$sess['dept_id']	= '034';
	// 					$sess['dept_name']	= 'ภาควิชาวิศวกรรมคอมพิวเตอร์ คณะวิศวกรรมศาสตร์';
	// 					$sess['type']				= 'student';
	// 					$this->session->set_userdata($sess);

	// 				} else if($dept > 0 && $dept < 100) {
	// 					$sess['fac']	= $dept;
	// 					$sess['level']	= 2;
	// 					$this->session->set_userdata($sess);

	// 				} else {
	// 					redirect('?fail=notallow');
	// 				}
	// 			}
	// 		} else {
	// 			redirect('?fail=wrong');
	// 		}
	// 		redirect();
	// 	}
	// }
	
	// public function logout() {
	// 	$this->session->sess_destroy();
	// 	redirect();
	// }
}
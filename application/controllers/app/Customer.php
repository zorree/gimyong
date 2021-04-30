<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Testconnect_model');	
		header("Cache-Control: public, max-age=60, s-maxage=60");
	}

	public function index() {
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF8");
		$data = $this->Testconnect_model->load_testconnect();
		echo json_encode($data);
	}

	public function insert() {

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF8");

		if($this->input->post()){
			$name = $this->input->post('name');
			$lname = $this->input->post('lname');
			$this->Testconnect_model->insert($name, $lname);
			$callback = ['status' => '200' ,'msg' =>'success'];
		}else{
			$callback = ['status' => '100' ,'msg' =>'NO success'];
		}		

		echo json_encode($callback);
	}

	public function delete() {
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF8");
		// header('Content-Type: application/json');
		// header('Access-Control-Allow-Methods: GET');
		// header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
		
		if($this->input->post()){
			$id = $this->input->post('id');
			$this->Testconnect_model->delete($id);
			$callback = ['status' => '200' ,'msg' =>'success'];
		}else{
			$callback = ['status' => '100' ,'msg' =>'NO success'];
		}		

		echo json_encode($callback);
	}

	public function sentmap() {
		if($this->input->get()){
			$callback = [
				'status'	=> '200',
				'msg'		=> 'success', 
				'm_lat'		=> $this->input->get('m_lat'),
				'm_lng'		=> $this->input->get('m_lng'),
			];

		}else{
			$callback = [
				'status' => '100',
				'msg' =>'NO success'
			];
		}		

		echo $callback['status'];
	}


}
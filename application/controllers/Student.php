<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('StudentModel');
		$this->session->userdata('type') == 'student' ?: redirect();
	}
	public function index() {
		$data['profile']	= $this->PrepareModel->loadDataid('profile', 'username', $this->session->userdata('username'));
		$data['address']	= $this->StudentModel->loadAddress();
		$data['parent']		= $this->StudentModel->loadParent();
		$data['regist']		= $this->StudentModel->registNow();
		$data['content']	= 'student/index';
		$this->load->view('include/layout', $data);
	}

	public function apply($regist_id){
		$data['student']	= $this->StudentModel->loadStudentidRegistid($regist_id);
		if(count($data['student']) > 0) {
			$data['profile']	= $this->PrepareModel->loadDataid('profile', 'username', $this->session->userdata('username'));
			$data['regist']		= $this->StudentModel->loadRegistid($regist_id);
			$data['address']	= $this->StudentModel->loadAddressRegist_id($regist_id);
			$data['parent']		= $this->StudentModel->loadParentRegist_id($regist_id);
			$data['content'] = 'student/apply';
			$this->load->view('include/layout', $data);
		} else {
			redirect('admin');
		}
	}
	public function exportPDF($dept_id){
		$working = $this->StudentModel->loadWorkingStatus2($dept_id);
		$dept = $this->StudentModel->loadDeptid($dept_id);
		$m = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
		// print_r($working);
		// เรียกไฟล์ TCPDF Library เข้ามาใช้งาน กำหนดที่อยู่ตามที่แตกไฟล์ไว้
		require_once('assets/lib/tcpdf/tcpdf.php');
		/* Print PDF */
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(site_url());
		$pdf->SetTitle('FundJob');

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(10, 10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetFont('thsarabunnew', '', 12, '', true);
		$pdf->SetAlpha(1);

		$pdf->AddPage();

		$html	= '<table>
			<tr>
				<td align="center"><b>ใบลงเวลาทำงาน</b></td>
			</tr>
			<tr>
				<td align="center">คณะกรรมการจัดสรรทุนการศึกษา</td>
			</tr>
			<tr>
				<td align="center">ใบลงเวลาทำงานประจำงวดที่..........รุ่นที่..........</td>
			</tr>
			<tr>
				<td align="center">รหัสนักศึกษา <u> '.$this->session->userdata('username').' </u> ชื่อนักศึกษา <u> '.$this->session->userdata('name').' </u> ภาควิชา/คณะ <u> '.$this->session->userdata('dept_name').' </u> </td>
			</tr>
			<tr>
				<td align="center">ทำงานให้กับภาควิชา/หน่วยงาน <u> '.$dept[0]['dept'].' </u></td>
			</tr>
		</table>';

		$html	.= '<br/>';
		$html	.= '<table>';
			$html	.= '<tr>
				<td width="5%" border="0.5"></td>
				<td align="center" width="10%" border="0.5"><b>วันทำงาน</b></td>
				<td align="center" width="12%" border="0.5"><b>เวลา มา-กลับ</b></td>
				<td align="center" width="7%" border="0.5"><b>รวมเวลา</b></td>
				<td align="center" width="66%" border="0.5" colspan="2"><b>งานที่ทำ</b></td>
			</tr>';
			$num = 0; $sumH = 0; $sumM = 0;
			foreach($working as $r){
				$start = strtotime($r['working_start']);
				$stop = strtotime($r['working_stop']);
				$html	.= '<tr>';
					$html	.= '<td align="center" border="0.5">'.(++$num).'</td>
					<td align="center" border="0.5">'.date('j', $start).' '.$m[date('n', $start) - 1].' '.(date('y', $start) + 43).'</td>
					<td align="center" border="0.5">'.date('H:i', $start).' - '.date('H:i', $stop).'</td>
					<td align="center" border="0.5">';
					$hour = (int)$r['total'];
					$minute = abs($r['total'] - round($r['total']));
					$minute = ($minute > 0 ? '30' : '0');
					$sumH += $hour;
					$sumM += $minute;

					$html .= $hour.':'.$minute.($minute < 10 ? '0' : '');
					$html	.= '</td>';
					$html	.= '<td align="center" border="0.5" colspan="2">'.$r['working_detail'].'</td>';
				$html	.= '</tr>';
			}
			$sumH += ($sumM/60); $sumM = ($sumM%60);
			$html	.= '<tr>
				<td colspan="3" align="right" border="0.5"><b>รวม</b>&nbsp;&nbsp;</td>
				<td align="center" border="0.5">'.(int)$sumH.':'.$sumM.($sumM < 10 ? '0' : '').'</td>
				<td colspan="2"></td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td align="center" width="33%">
					ลงชื่อ...................................<br/>
					('.$this->session->userdata('name').')<br/>
					<b>ผู้ปฏิบัติงาน</b>
				</td>
				<td align="center" width="33%">
					ลงชื่อ...................................<br/>
					('.$dept[0]['dept_admin'].')<br/>
					<b>ผู้ควบคุม</b>
				</td>
			</tr>
		</table>';
		
		$pdf->writeHtml($html);
		$pdf->Output('working-'.$this->session->userdata('username').'.pdf', 'I');
	}


	public function history() {
		$data['history'] = $this->StudentModel->loadStudent();
		$data['content'] = 'student/history';
		$this->load->view('include/layout', $data);
	}
	public function addrSearch() {
		foreach ($this->StudentModel->addrSearch($this->input->get('addr')) as $ar) {
			echo "<p>{$ar['district_name']} >> {$ar['amphure_name']} >> <b>{$ar['province_name']}</b> >> ".($ar['zip_code'] != null ? $ar['zip_code'] : '-')." <small>({$ar['district_id']})</small></p>";
		}
	}

	public function working($dept_id) {
		$checkDept = $this->StudentModel->checkDept($dept_id);
		// echo count($checkDept);
		count($checkDept) > 0 ? : redirect('student/history');

		$data['dept'] = $this->StudentModel->loadDeptid($dept_id);
		$data['student'] = $this->StudentModel->loadStudentid();
		$data['listWorking'] = $this->StudentModel->loadWorking($dept_id);
		$data['content'] = 'student/working';
		$this->load->view('include/layout', $data);
	}

	public function addWorking() {
		// print_r($this->input->post());
		if($this->input->post()) {
			$ar = [
				'dept_id' => $this->input->post('dept_id'),
				'working_detail' => $this->input->post('working_detail'),
				'student_id' => $this->session->userdata('username'),
				'working_start' => "{$this->input->post('date')} {$this->input->post('startH')}:{$this->input->post('startM')}:00",
				'working_stop' => "{$this->input->post('date')} {$this->input->post('stopH')}:{$this->input->post('stopM')}:00",
			];
			$checkOverlap = $this->StudentModel->checkOverlap($ar['working_start'], $ar['working_stop'], $ar['dept_id']);

			$start = strtotime($ar['working_start']);
			$stop = strtotime($ar['working_stop']);
			$interval = $stop - $start;
			$hour = (int)($interval / (60 * 60));
			$minute = (int)(($interval % (60 * 60)) / 60);
			$hour -= date('Gi', $start) < 1200 && date('Gi', $stop) > 1300 ? 1 : 0;
			$ar['total'] = $hour.($minute < 30 ? '' : '.5');

			if(strtotime($ar['working_start']) < strtotime($ar['working_stop']) && count($checkOverlap) == 0) {
				$this->PrepareModel->insertData('working', $ar);
				redirect('student/working/'.$ar['dept_id']);
			}
			else {
				echo '<script>alert("เวลาไม่ถูกต้อง โปรดตรวจสอบวันเวลาว่าไม่ซ้ำกับ เวลาลงทำงานอื่น");window.location="'.site_url('student/working/').$ar['dept_id'].'";</script>';
			}
		}
		echo '<script>alert("ผิดพลาด");window.location="'.site_url('student/working/').$ar['dept_id'].'";</script>';
	}
	public function selectDept($dept_id, $regist_id){
		$regist = $this->StudentModel->loadRegistid($regist_id);
		$dept = $this->StudentModel->checkDeptRegistStudent($regist_id, $dept_id);
		if(count($regist) > 0 && count($dept) > 0) {
			$now = time();
			$start = strtotime($regist[0]['dept_start']);
			$stop = strtotime('+1 day', strtotime($regist[0]['dept_stop']));

			if($now >= $start && $now < $stop) {
				if($dept[0]['student_id'] == null) {
					$this->StudentModel->studentSelectDept($regist_id, $dept_id);
					redirect('student/history');
				} else {
					echo '<script>alert("หน่วยงานที่เลือก เต็มแล้ว");window.location="'.site_url('student/history').'";</script>';
				}
			}
		}
		echo '<script>alert("ผิดพลาด");window.location="'.site_url('student/history').'";</script>';
	}
	public function loadDeptRegistid() {
		$dept = $this->StudentModel->loadDeptRegistid($this->input->post('regist_id'));
		echo json_encode($dept);
	}
	
	public function register(){
		$regist_id = $this->input->post('regist_id');
		$ar['address'] = array_map(function($v) {
			return $v === "" ? NULL : $v;
		}, $this->input->post('address'));
		$ar['parent'] = array_map(function($v) {
			return $v === "" ? NULL : $v;
		}, $this->input->post('parent'));

		$ar['profile']	= $this->input->post('profile');
		$ar['address']['student_id'] = $this->session->userdata('username');
		$ar['parent']['student_id'] = $this->session->userdata('username');
		
		$this->StudentModel->register($ar, $regist_id);
	}

	public function deleteWorking($working_id){
		$checkWorkingStatus = $this->StudentModel->checkWorkingStatus($working_id);
		// print_r($checkWorkingStatus);
		if(count($checkWorkingStatus) > 0 ){
			$this->PrepareModel->deleteData('working', 'working_id', $working_id);
			redirect('student/working/'.$checkWorkingStatus[0]['dept_id']);
		}else {
			echo '<script>alert("ไม่สามารถลบวันเวลานี้ได้ เนื่องจากได้มีการอนุมัติแล้ว");window.location="'.site_url('student/working').$checkWorkingStatus[0]['dept_id'].'";</script>';
		}
	}

	public function deleteDept($regist_id){
		$regist = $this->StudentModel->loadRegistid($regist_id);
		if(count($regist) > 0) {
			$now = time();
			$start = strtotime($regist[0]['dept_start']);
			$stop = strtotime('+1 day', strtotime($regist[0]['dept_stop']));

			if($now >= $start && $now < $stop) {
				$this->StudentModel->deleteDept($regist_id);
			}
		}
		redirect('student/history');
	
	}


}
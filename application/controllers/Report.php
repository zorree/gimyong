<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ReportModel');
		$this->session->userdata('type') == 'admin' && $this->session->userdata('level') == 0 ?: redirect();
	}

	public function round() {
		$data['year'] = $this->ReportModel->loadYear();
		$data['content'] = 'report/round';
		$this->load->view('include/layout', $data);
	}

	public function loadReportRound(){
		// print_r($this->input->post());
		echo json_encode($this->ReportModel->loadReportRound($this->input->post()));
	}

	public function loadTerm() {
		echo json_encode($this->ReportModel->loadTerm($this->input->post()));
	}
	public function loadRound() {
		echo json_encode($this->ReportModel->loadRound($this->input->post()));
	}

	public function excelround(){
		$post = $this->input->post();
		$listReport = $this->ReportModel->loadReportRound($post);

		if(count($listReport) > 0) {
			$round 			= $this->ReportModel->loadRoundRegistid($listReport[0]['regist_id']);
			require_once './assets/lib/PHPExcel/Classes/PHPExcel.php';

			// Create new PHPExcel object
			$objPHPExcel				= new PHPExcel();
			$border['thin']		= ['borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]];
			$border['tMedium']	= ['borders' => ['top' => ['style' => PHPExcel_Style_Border::BORDER_MEDIUM]]];
			$border['lMedium']	= ['borders' => ['left' => ['style' => PHPExcel_Style_Border::BORDER_MEDIUM]]];
			$style['bold'] 		= ['font' => ['bold' => true]];

			$header = 'รายชื่อนักศึกษาทุนทำงานแลกเปลี่ยน ประจำ';
			$header .= $post['round_id'] != '' ? $round[0]['round_num'].' ' : '';
			$header .= $post['regist_term'] != '' ? 'ภาคเรียนที่ '.$post['regist_term'].'/' : 'ปีการศึกษา ';
			$header .= ($post['regist_year'] + 543);

			$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);

			// SET auto width
			for ($char = 'A'; $char <= 'E'; $char++) {
				$objWorkSheet->getColumnDimension($char)->setAutoSize(true);
			}

			// Set title
			$objWorkSheet->getStyle('A1')->getFont()->setSize(12);
			$objWorkSheet->mergeCells('A1:E1');
			$objWorkSheet->setCellValue('A1', $header);

			// Set header
			$objWorkSheet
				->setCellValue("A2", 'ลำดับ')
				->setCellValue("B2", 'รหัสนักศึกษา')
				->setCellValue("C2", 'ชื่อ - สกุล')
				->setCellValue("D2", 'เลขบัญชี')
				->setCellValue("E2", 'จำนวนเงิน');

			$row = 2;
			$sum = 0;
			foreach ($listReport as $r) {
				$row++;
				// Set value list
				$objWorkSheet
					->setCellValue("A{$row}", $row - 1)
					->setCellValue("B{$row}", $r['student_id'])
					->setCellValue("C{$row}", $r['name'])
					->setCellValue("D{$row}", $r['bank'])
					->setCellValue("E{$row}", number_format($r['sum'] * 40));
				$sum += $r['sum'] * 40;
			}

			$row++;
			$objWorkSheet->mergeCells("A{$row}:D{$row}");
			$objWorkSheet
				->setCellValue("A{$row}", 'รวม')
				->setCellValue("E{$row}", $sum);
			$objWorkSheet->getStyle("E{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			//Set border
			$objWorkSheet->getStyle("A2:E{$row}")->applyFromArray($border['thin']);
			$objWorkSheet->getStyle("A2:E2")->applyFromArray($border['tMedium']);
			$objWorkSheet->getStyle("A3:E3")->applyFromArray($border['tMedium']);
			$objWorkSheet->getStyle("A2")->applyFromArray($border['lMedium']);
			$objWorkSheet->getStyle("F2")->applyFromArray($border['lMedium']);
			$objWorkSheet->getStyle("A{$row}:E{$row}")->applyFromArray($border['tMedium']);

			//Set style
			$objWorkSheet->getStyle('A1')->applyFromArray($style['bold']);
			$objWorkSheet->getStyle('A2:E2')->applyFromArray($style['bold']);
			$objWorkSheet->getStyle("A{$row}:E{$row}")->applyFromArray($style['bold']);

			// Set horizontal
			$objWorkSheet->getStyle("A1:E{$row}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objWorkSheet->getStyle("A1:E{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->getStyle("C2:C{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objWorkSheet->getStyle("E2:E{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objWorkSheet->getStyle("A{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('รายงานงบประมาณประจำงวด')
				->getPageSetup()
					->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
					->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
					->setFitToPage(true)
					->setFitToWidth(1)
					->setFitToHeight(0);

			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$header.'.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			$objWriter	= PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit();
		} else {
			echo '<script>alert("ไม่มีข้อมูล");window.location="'.site_url('report/round').'";</script>';
		}
	}
}
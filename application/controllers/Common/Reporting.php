<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reporting extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('excel');
		$this->load->library('cezpdf');
		
		//load the model
		$this->load->model('setup_model');
		$this->load->model('header_model');
		$this->load->model('reporting_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Index()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/footer');
		$this->load->view('../Reporting/Index');
	}
	
	public function FeedbackSumm()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		$this->load->view('../Reporting/feedbackSumm');
	}
	
	public function FeedbackDetails()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		$this->load->view('../Reporting/feedbackDetails');
	}
	
	public function FacilityBooking()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		$this->load->view('../Reporting/facilitiesDetails');
	}
	
	public function Feedbacks($page=1)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['status'] = $this->reporting_model->get_Status();
		$data['category'] = $this->reporting_model->get_Category();
		$data['totalStat'] = $this->reporting_model->get_status_count();
		$data['totalCat'] = $this->reporting_model->get_categories_count();
		$data['feedCnt'] = $this->reporting_model->get_feedback_count();
		$data['keyword'] = 'All';
		
		$results = $this->reporting_model->get_feedback_search(NULL);
        $data['results'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();
		
        if (count($results) > 0) {
            $paginatedFiles = array_slice($results, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['results'][] = array('feedbackID'=>$file['feedbackID'],
										   'createdDate'=>$file['createdDate'],
										   'unitNo'=>$file['unitNo'],
										   'priority'=>$file['priority'],
										   'status'=>$file['status'],
										   'category'=>$file['category'],
										   'subject'=>$file['subject'],
										   'closedDate'=>$file['closedDate'],
										   'remark'=>$file['remark'],
										   'daysTaken'=>$file['daysTaken']);
            }
        }

		//pagination
        $config['base_url'] = base_url()."index.php/Common/Reporting/Feedbacks";
        $config['total_rows'] = count($results);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
		$config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo;';
        $config['last_link'] = '&laquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
		
        $this->pagination->initialize($config);

		//load the view
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/footer');
		$this->load->view('Mgmt/Reporting/Feedbacks',$data);
	}
	
	function SearchFeedbacks()
    {
		$data['company'] = $this->header_model->get_Company();
		$data['status'] = $this->reporting_model->get_Status();
		$data['category'] = $this->reporting_model->get_Category();
		$data['totalStat'] = $this->reporting_model->get_status_count();
		$data['totalCat'] = $this->reporting_model->get_categories_count();
		$data['feedCnt'] = $this->reporting_model->get_feedback_count();
		
        // get search string
        $search = ($this->input->post("keyword"))? $this->input->post("keyword") : "All";
        $search = ($this->uri->segment(4)) ? $this->uri->segment(4) : $search;
		
        // pagination
        $config = array();
        $config['base_url'] = base_url()."index.php/Common/Reporting/SearchFeedbacks/".$search;
        $config['total_rows'] = $this->reporting_model->get_feedback_count($search);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $choice = $config['total_rows']/$config['per_page'];
        $config['num_links'] = floor($choice);
		$config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo;';
        $config['last_link'] = '&laquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
		
        $this->pagination->initialize($config);
		
		$data['keyword'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post("keyword");
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;
		$results = $this->reporting_model->get_feedback_search($search);
		
		$data['results'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();
		
        if (count($results) > 0) {
            $paginatedFiles = array_slice($results, $offset, 10, true);
        }

		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['results'][] = array('feedbackID'=>$file['feedbackID'],
										   'createdDate'=>$file['createdDate'],
										   'unitNo'=>$file['unitNo'],
										   'priority'=>$file['priority'],
										   'status'=>$file['status'],
										   'category'=>$file['category'],
										   'subject'=>$file['subject'],
										   'closedDate'=>$file['closedDate'],
										   'remark'=>$file['remark'],
										   'daysTaken'=>$file['daysTaken']);
            }
        }


        //load view
        $this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/footer');
		$this->load->view('Mgmt/Reporting/Feedbacks',$data);
    }

	public function FeedbackExcel($keyword)
	{ 
		$objPHPExcel = new PHPExcel();
		$sheet = $objPHPExcel->getActiveSheet();
		
		$total = $this->reporting_model->get_feedback_count($keyword);
		
		// Trying to set a column name
		$sheet->SetCellValue('A1', 'Total: '.$total);
        $sheet->SetCellValue('A2', 'ID');
        $sheet->SetCellValue('B2', 'Date');
        $sheet->SetCellValue('C2', 'Unit No');
        $sheet->SetCellValue('D2', 'Priority');
        $sheet->SetCellValue('E2', 'Status');
        $sheet->SetCellValue('F2', 'Category');
        $sheet->SetCellValue('G2', 'Subject');
        $sheet->SetCellValue('H2', 'Closing Date');
        $sheet->SetCellValue('I2', 'Description');
        $sheet->SetCellValue('J2', 'Management Remark');
        $sheet->SetCellValue('K2', 'Days Taken');

		$feedback = $this->reporting_model->get_feedback_search_print($keyword);
		$sheet->fromArray($feedback, null, 'A3');	
		$sheet->getStyle("A2:K2")->getFont()->setBold(true);
		$sheet->getStyle("A1")->getFont()->setBold(true);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		$filename='Feedback.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); 
	}

	public function FeedbackPdf($keyword)
	{
		$pdf = new CezPDF('a4', 'landscape');
		if (strpos(PHP_OS, 'WIN') !== false) {
			$pdf->tempPath = 'C:\\Windows\temp';
		}
		$pdf->selectFont('Helvetica');
		
		// some general data used for table output
		$feedback = $this->reporting_model->get_feedback_search_print($keyword);
		$data = array();
		foreach ($feedback as $row) {
			$data[] = $row;
		}
		$total = $this->reporting_model->get_feedback_count($keyword);
		$cols = array("feedbackID" => "ID", "createdDate" => "Date", "unitNo" => "Unit No", 
					  "priority" => "Priority", "status" => "Status", "category" => "Category",
					  "subject" => "Subject", "closedDate" => "Closing Date", "description" => "Resident's Feedback", 
					  "remark" => "Management Response", "daysTaken" => "Days Taken");

		$pdf->ezText("<b>Feedback</b>", 12);
		$pdf->ezText("<b>Total: ".$total."</b>\n",12);
		$pdf->ezTable($data, $cols);
		
		if (isset($_GET['d']) && $_GET['d']) {
			echo $pdf->ezOutput(true);
		} else {
			$pdf->ezStream();
		}
	}
	
	public function Facilities($page=1)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['status'] = $this->reporting_model->get_BookingStatus();
		$data['bookingType'] = $this->reporting_model->get_BookingType();
		$data['keyword'] = 'All';
		
		$results = $this->reporting_model->get_facilities_search(NULL);
        $data['results'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();
		
        if (count($results) > 0) {
            $paginatedFiles = array_slice($results, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['results'][] = array('bookingID'=>$file['bookingID'],
										   'bookingType'=>$file['bookingType'],
										   'dateFrom'=>$file['dateFrom'],
										   'timeFrom'=>$file['timeFrom'],
										   'timeTo'=>$file['timeTo'],
										   'unitNo'=>$file['unitNo'],
										   'status'=>$file['status']);
            }
        }

		//pagination
        $config['base_url'] = base_url()."index.php/Common/Reporting/Facilities";
        $config['total_rows'] = count($results);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
		$config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo;';
        $config['last_link'] = '&laquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
		
        $this->pagination->initialize($config);

		//load the view
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/footer');
		$this->load->view('Mgmt/Reporting/Facilities',$data);
	}
	
	function SearchFacilities()
    {
		$data['company'] = $this->header_model->get_Company();
		$data['status'] = $this->reporting_model->get_BookingStatus();
		$data['bookingType'] = $this->reporting_model->get_BookingType();
		
        // get search string
        $search = ($this->input->post("keyword"))? $this->input->post("keyword") : "All";
        $search = ($this->uri->segment(4)) ? $this->uri->segment(4) : $search;
		
        // pagination
        $config = array();
        $config['base_url'] = base_url()."index.php/Common/Reporting/SearchFacilities/".$search;
        $config['total_rows'] = $this->reporting_model->get_facilities_count($search);
        $config['per_page'] = 10;
        $config['uri_segment'] = 5;
        $choice = $config['total_rows']/$config['per_page'];
        $config['num_links'] = floor($choice);
		$config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo;';
        $config['last_link'] = '&laquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
		
        $this->pagination->initialize($config);
		
		$data['keyword'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post("keyword");
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;
		$results = $this->reporting_model->get_facilities_search($search);
		
		$data['results'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();
		
        if (count($results) > 0) {
            $paginatedFiles = array_slice($results, $offset, 10, true);
        }

		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['results'][] = array('bookingID'=>$file['bookingID'],
										   'bookingType'=>$file['bookingType'],
										   'dateFrom'=>$file['dateFrom'],
										   'timeFrom'=>$file['timeFrom'],
										   'timeTo'=>$file['timeTo'],
										   'unitNo'=>$file['unitNo'],
										   'status'=>$file['status']);
            }
        }


        //load view
        $this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/footer');
		$this->load->view('Mgmt/Reporting/Facilities',$data);
    }
	
	public function FacilitiesExcel($keyword)
	{ 
		$objPHPExcel = new PHPExcel();
		$sheet = $objPHPExcel->getActiveSheet();
		
		// Trying to set a column name
        $sheet->SetCellValue('A1', 'ID');
        $sheet->SetCellValue('B1', 'Facilities');
        $sheet->SetCellValue('C1', 'Unit No');
        $sheet->SetCellValue('D1', 'Date From');
        $sheet->SetCellValue('E1', 'Time From');
        $sheet->SetCellValue('F1', 'Time To');
        $sheet->SetCellValue('G1', 'Status');

		$facilities = $this->reporting_model->get_facilities_search($keyword);
		$sheet->fromArray($facilities, null, 'A2');
		$sheet->getStyle("A1:G1")->getFont()->setBold(true);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		$filename='Facilities.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); 
	}
	
	public function FacilitiesPdf($keyword)
	{
		$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
		$rendererLibraryPath = APPPATH.'/third_party/mpdf60';
		
		$objPHPExcel = new PHPExcel();
		$sheet = $objPHPExcel->getActiveSheet();
	 
		// Trying to set a column name
        $sheet->SetCellValue('A1', 'ID');
        $sheet->SetCellValue('B1', 'Facilities');
        $sheet->SetCellValue('C1', 'Unit No');
        $sheet->SetCellValue('D1', 'Date From');
        $sheet->SetCellValue('E1', 'Time From');
        $sheet->SetCellValue('F1', 'Time To');
        $sheet->SetCellValue('G1', 'Status');

		$facilities = $this->reporting_model->get_facilities_search($keyword);
		$cntData = count($facilities)+1;
		
		$sheet->fromArray($facilities, null, 'A2');
		
		// Style Sheet
		$sheet->setTitle('Facilities');
		$sheet->getStyle("A1:G".$cntData)->getFont()->setSize(9);
		$sheet->getStyle("A1:G".$cntData)->getFont()->setName('Times New Roman');
		$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$sheet->getPageSetup()->setFitToPage(true);
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(0);
		
		$styleArray = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$sheet->getStyle("A1:G".$cntData)->applyFromArray($styleArray);
		$sheet->getStyle("A1:G1")->getFont()->setBold(true);
		
		for($col = 'A'; $col !== 'F'; $col++) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}
		
		$sheet->getColumnDimension('F')->setWidth(25);
		$sheet->getColumnDimension('G')->setWidth(25);
		$sheet->getStyle("A1:G".$cntData)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	 
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
			
		if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
			die(
				'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
				'<br />' .
				'at the top of this script as appropriate for your directory structure'.
				
				'</br>'.$rendererName.
				'</br>'.$rendererLibraryPath
			);
		}
		
		$filename='Facilities.pdf'; //save our workbook as this file name
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		$objWriter->save('php://output');
	}
}
?>
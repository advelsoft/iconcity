<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class facilityBooking extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		$this->cportal = $this->load->database('cportal',TRUE);
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('Curl');
		$this->load->library('PHPRequests');
		
		//load the model
		$this->load->model('facilityBooking_model');
		$this->load->model('header_model');  
		$this->jompay = $this->load->database('jompay',TRUE);
		
		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Index()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['facilityBookingList'] = $this->facilityBooking_model->get_bookingType_list();           
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/FacilityBooking/index',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/FacilityBooking/index',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function History($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $facilityHistory = $this->facilityBooking_model->get_bookingType_history();
        $data['facilityBookingHistory'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($facilityHistory) > 0) {
            $paginatedFiles = array_slice($facilityHistory, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['facilityBookingHistory'][] = array('description'=>$file['description'],
														  'dateFrom'=>$file['dateFrom'],
														  'timeFrom'=>$file['timeFrom'],
														  'timeTo'=>$file['timeTo'],
														  'propertyNo'=>$file['propertyNo']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/FacilityBooking/History";
        $config['total_rows'] = count($facilityHistory);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
        //load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/FacilityBooking/History',$data);
		}
	}
	
	public function Calendar($BookingTypeID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/FacilityBooking/Calendar');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/FacilityBooking/Calendar');
		}
	}
	
	public function Create($BookingTypeID)
	{
		//call the model
		$data['bookingTypeID'] = $BookingTypeID;
		$data['company'] = $this->header_model->get_Company();
		$data['bookingTypeDesc'] = $this->facilityBooking_model->get_BookingTypeDesc($BookingTypeID);	
		$data['usersPropNo'] = $this->facilityBooking_model->get_PropertyNo();	
		$data['timeFrom'] = $this->facilityBooking_model->get_TimeFrom();	
		$data['timeTo'] = $this->facilityBooking_model->get_TimeTo();	
		$data['bookingStatus'] = $this->facilityBooking_model->get_Status();
		$data['schedule'] = $this->facilityBooking_model->get_ScheduleList($BookingTypeID);
		$bookingTypeGroup = $this->facilityBooking_model->get_BookingTypeGroup($BookingTypeID);
		$blackList = $this->facilityBooking_model->get_Blacklist();
		if(isset($blackList['overdueAmount']) && count($blackList['overdueAmount']) > 0){
			$data['OverdueAmount'] = $blackList['overdueAmount'];
		}
		
		//set validation rules
        $this->form_validation->set_rules('BookingTypeID', 'Description', 'callback_combo_check');
        $this->form_validation->set_rules('PropertyNo', 'Property No', 'callback_combo_check');
        $this->form_validation->set_rules('Status', 'Status', 'callback_combo_check');
        $this->form_validation->set_rules('DateFrom', 'Date', 'required');
        $this->form_validation->set_rules('TimeFrom', 'Time From', 'callback_combo_check');
        $this->form_validation->set_rules('TimeTo', 'Time To', 'callback_combo_check');
		if($_SESSION['role'] != 'Mgmt'){
			$this->form_validation->set_rules('accept_terms_checkbox', '', 'callback_accept_terms');
		}
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/FacilityBooking/Create', $data);
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/FacilityBooking/Create', $data);
			}
        }
        else
        {
			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			if($_SESSION['role'] == 'Mgmt'){
				$data = array(
					'BookingTypeID' => $BookingTypeID,
					'UserID' => $this->input->post('PropertyNo'),   
					'BStatusID' => $this->input->post('Status'),
					'DateFrom' => $this->input->post('DateFrom'),
					'DateTo' => $this->input->post('DateFrom'),
					'TimeFrom' => $this->input->post('TimeFrom'),
					'TimeTo' => $this->input->post('TimeTo'),
					'Remarks' => $this->input->post('Remarks'),
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
				);
				
				//insert record
				$this->cportal->insert('FacilitiesBooking', $data);
			
				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Booking Success");</script>');
				redirect('index.php/Common/FacilityBooking/Index');
			}
			else if($_SESSION['role'] == 'User'){
				//get propertyNo
				$this->cportal->from('Users');
				$this->cportal->where('USERID', $_SESSION['userid']);
				$query = $this->cportal->get();
				$user = $query->result();
				
				$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => trim($user[0]->CONDOSEQ), 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => trim($user[0]->USERID), 'FacilityId' => $BookingTypeID, 'Date' =>$this->input->post('DateFrom'), 'TimeFrom' => $this->input->post('TimeFrom'), 'TimeTo' => $this->input->post('TimeTo'), 'Feed' => 'Y');
				
				$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/FacilityBooking';
				$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
				$response = Requests::post($url, $headers, json_encode($jsonData));
				$body = json_decode($response->body, true);
				// echo '<pre>';
				// print_r($body); die();
				
				foreach($body as $key => $value)
				{
					if($key == 'Req'){
						$CondoSeqNo = $value['CondoSeqNo'];
						$UnitSeqNo = $value['UnitSeqNo'];
						$UserIdNo = $value['UserIdNo'];
					}
					else if($key == 'Resp'){
						$Status = $value['Status'];
						$FailedReason = $value['FailedReason'];
						$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
					}
				}

				//display message
				if($Status == 'F'){
					$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
					redirect('index.php/Common/FacilityBooking/Index');
				}
				else{
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Booking Success");</script>');
					redirect('index.php/Common/FacilityBooking/Index');
				}
			}
		}
	}

	public function Listed($BookingTypeID, $page=1)
	{
		//call the model
		$data['bookingTypeID'] = $BookingTypeID;
		$data['company'] = $this->header_model->get_Company();
        $facilityRecord = $this->facilityBooking_model->get_facilityBooking_list($BookingTypeID);
        $data['fbRecord'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($facilityRecord) > 0) {
            $paginatedFiles = array_slice($facilityRecord, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['fbRecord'][] = array('bookingID'=>$file['bookingID'],
										    'description'=>$file['description'],
										    'propertyNo'=>$file['propertyNo'],
										    'dateFrom'=>$file['dateFrom'],
										    'timeFrom'=>$file['timeFrom'],
										    'timeTo'=>$file['timeTo'],
										    'status'=>$file['status'],
											'createdDate'=>$file['createdDate']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/FacilityBooking/Listed/".$BookingTypeID;
        $config['total_rows'] = count($facilityRecord);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
        //load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/FacilityBooking/List',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/FacilityBooking/List',$data);
		}
	}
	
	public function Approval($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $facilityRecord = $this->facilityBooking_model->get_facilityBooking_approve();
        $data['fbRecord'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($facilityRecord) > 0) {
            $paginatedFiles = array_slice($facilityRecord, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['fbRecord'][] = array('bookingID'=>$file['bookingID'],
										    'description'=>$file['description'],
										    'propertyNo'=>$file['propertyNo'],
										    'dateFrom'=>$file['dateFrom'],
										    'timeFrom'=>$file['timeFrom'],
										    'timeTo'=>$file['timeTo'],
										    'status'=>$file['status']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/FacilityBooking/Approval";
        $config['total_rows'] = count($facilityRecord);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
        //load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/FacilityBooking/Approval',$data);
		}
	}
	
	public function Lists($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $fbRecord = $this->facilityBooking_model->get_facilityBooking_all();
        $data['fbRecord'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($fbRecord) > 0) {
            $paginatedFiles = array_slice($fbRecord, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['fbRecord'][] = array('description'=>$file['description'],
										    'propertyNo'=>$file['propertyNo'],
										    'dateFrom'=>$file['dateFrom'],
										    'timeFrom'=>$file['timeFrom'],
										    'timeTo'=>$file['timeTo'],
										    'status'=>$file['status'],
											'bookingID'=>$file['bookingID']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/FacilityBooking/Lists";
        $config['total_rows'] = count($fbRecord);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/FacilityBooking/List',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/FacilityBooking/List',$data);
		}
	}
	
	public function Detail($BookingID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['fbRecord'] = $this->facilityBooking_model->get_facilityBooking_record($BookingID);

		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/FacilityBooking/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/FacilityBooking/Detail',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function Update($BookingID)
	{
		//call the model
		$data['bookingID'] = $BookingID;
		$data['company'] = $this->header_model->get_Company();
		$data['bookingTypeDesc'] = $this->facilityBooking_model->get_BookingDesc($BookingID);	
		$data['usersPropNo'] = $this->facilityBooking_model->get_PropertyNo();	
		$data['timeFrom'] = $this->facilityBooking_model->get_TimeFrom();	
		$data['timeTo'] = $this->facilityBooking_model->get_TimeTo();
		$data['bookingStatus'] = $this->facilityBooking_model->get_Status();
		$data['fbRecord'] = $this->facilityBooking_model->get_facilityBooking_record($BookingID);
		$data['schedule'] = $this->facilityBooking_model->get_ScheduleUpdate($BookingID);

        //set validation rules
		$this->form_validation->set_rules('BookingTypeID', 'Description', 'callback_combo_check');
        $this->form_validation->set_rules('PropertyNo', 'Property No', 'callback_combo_check');
        $this->form_validation->set_rules('Status', 'Status', 'callback_combo_check');
        $this->form_validation->set_rules('DateFrom', 'Date', 'required');
        $this->form_validation->set_rules('TimeFrom', 'Time From', 'required');
        $this->form_validation->set_rules('TimeTo', 'Time To', 'required');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/FacilityBooking/Update', $data);
			}
        }
        else
        {
            //validation succeed
			$this->cportal->from('BookingType');
			$this->cportal->where('Description', $this->input->post('Description'));
			$query = $this->cportal->get();
			$result = $query->result();
			
            $data = array(
                'BookingTypeID' => $result[0]->BookingTypeID,
                'UserID' => $this->input->post('userid'),
                'BStatusID' => $this->input->post('Status'),
                'DateFrom' => $this->input->post('DateFrom'),
                'TimeFrom' => $this->input->post('TimeFrom'),
                'TimeTo' => $this->input->post('TimeTo'),
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );
			
			//get propertyNo
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $this->input->post('userid'));
			$query = $this->cportal->get();
			$user = $query->result();
			
			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => trim($user[0]->CONDOSEQ), 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => trim($user[0]->USERID), 
							  'FacilityId' => $result[0]->BookingTypeID, 'BookingId' => $BookingID, 'Status' => $this->input->post('Status'), 'Feed' => 'Y');
			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/FacilityBookingEdit';
			$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
			$response = Requests::post($url, $headers, json_encode($jsonData));
			$body = json_decode($response->body, true);
			//echo '<pre>';
			//print_r($body);
			
			foreach($body as $key => $value)
			{
				if($key == 'Req'){
					$CondoSeqNo = $value['CondoSeqNo'];
					$UnitSeqNo = $value['UnitSeqNo'];
					$UserIdNo = $value['UserIdNo'];
				}
				else if($key == 'Resp'){
					$Status = $value['Status'];
					$FailedReason = $value['FailedReason'];
					$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
				}
			}

			//display message
			if($Status == 'F'){
				$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
				redirect('index.php/Common/FacilityBooking/Index');
			}
			else{
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Booking Updated!");</script>');
				redirect('index.php/Common/FacilityBooking/Index');
			}
        }
	}
	
	public function Delete($BookingID)
	{
		//call the model
		$data['bookingID'] = $BookingID;
		$data['company'] = $this->header_model->get_Company();
		$data['fbRecord'] = $this->facilityBooking_model->get_facilityBooking_record($BookingID);
		
		//set validation rules
		$this->form_validation->set_rules('Remarks', 'Remarks', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			//validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/FacilityBooking/Delete',$data);
				$this->load->view('Mgmt/footer');
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/FacilityBooking/Delete',$data);
				$this->load->view('User/footer');
			}
		}
		else {
			//validation succeed
			$this->cportal->from('FacilitiesBooking');
			$this->cportal->where('BookingID', $BookingID);
			$query = $this->cportal->get();
			$result = $query->result();
			
			//get userid
			$this->cportal->from('Users');
			$this->cportal->where('UserID', $result[0]->UserID);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//insert to FacilitiesBookingLog
			$data = array(
					'BookingTypeID' => $result[0]->BookingTypeID,
					'PropertyNo' => $user[0]->PROPERTYNO,
					'BStatusID' => $result[0]->BStatusID,
					'DateFrom' => $result[0]->DateFrom,
					'TimeFrom' => $result[0]->TimeFrom,
					'TimeTo' => $result[0]->TimeTo,
					'Remarks' => $this->input->post('Remarks'),
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
					'CondoSeq'=> $_SESSION['condoseq'],
			);
			
			//insert record
			$this->cportal->insert('FacilitiesBookingLog', $data);
			
			//delete record
			$this->cportal->where('BookingID', $BookingID);
			$this->cportal->delete('FacilitiesBooking');
			
			//display message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Booking Deleted!");</script>');
			if($_SESSION['role'] == 'Mgmt'){
				redirect('index.php/Common/FacilityBooking/Listed/'.$result[0]->BookingTypeID);
			}
			else {
				redirect('index.php/Common/FacilityBooking/Lists');
			}
		}
	}
	
	//custom validation function for dropdown input
    function combo_check($str)
    {
        if ($str == '0')
        {
            $this->form_validation->set_message('combo_check', 'The %s field is required');
            return FALSE;
        }
        else
        {
            return TRUE;
		}
	}

	function accept_terms()
	{
        if ($this->input->post('accept_terms_checkbox'))
		{
			return TRUE;
		}
		else
		{
			$error = 'Please read and accept our terms and conditions.';
			$this->form_validation->set_message('accept_terms', $error);
			return FALSE;
		}
	}

	public function BookingPdf()
	{
		$datefrom = $this->input->post('datefrom');
		$datefrom = str_replace('/', '-', $datefrom);
		$datefrom = date("Y-m-d", strtotime($datefrom));
		$dateto = $this->input->post('dateto');
		$dateto = str_replace('/', '-', $dateto);
		$dateto = date("Y-m-d", strtotime($dateto));

		$sessiondata = array(
						'datefrom'=>$datefrom, 
						'dateto'=>$dateto
					);
        $this->session->set_userdata($sessiondata);
        
		//load the view
		$this->load->view('../Reporting2/facilitiesBooking');
	}
}?>
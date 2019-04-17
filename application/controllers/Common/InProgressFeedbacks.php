<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inprogressfeedbacks extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('Curl');
		$this->load->library('PHPRequests');
		
		//load the model
		$this->load->model('inprogressfeedback_model');
		$this->load->model('header_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
			$this->session->set_userdata('previous_page', uri_string());
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Index($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $fbList = $this->inprogressfeedback_model->get_feedbacks_list();
        $data['feedbacksList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($fbList) > 0) {
            $paginatedFiles = array_slice($fbList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['feedbacksList'][] = array('propertyNo'=>$file['propertyNo'],
													 'priority'=>$file['priority'],
													 'status'=>$file['status'],
													 'incidentType'=>$file['incidentType'],
													 'subject'=>$file['subject'],
													 'createdDate'=>$file['createdDate'],
													 'feedbackID'=>$file['feedbackID'],
													 'maxDate'=>$file['maxDate'],
													 'ownerName'=>$file['ownerName']);
				}
				else{
					$data['feedbacksList'][] = array('feedbackID'=>$file['feedbackID'],
												     'status'=>$file['status'],
												     'incidentType'=>$file['incidentType'],
												     'subject'=>$file['subject'],
												     'createdDate'=>$file['createdDate'],
												     'maxDate'=>$file['maxDate']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/InProgressFeedbacks/Index";
        $config['total_rows'] = count($fbList);
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
			$this->load->view('Mgmt/Feedbacks/InProgressFeedbacks/Index',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Feedbacks/InProgressFeedbacks/Index',$data);
		}
	}
	
	public function Detail($UID)
	{
		//call the model
		$data['UID'] = $UID;
		$data['company'] = $this->header_model->get_Company();
		$data['priority'] = $this->inprogressfeedback_model->get_Priority();
		$data['assignTo'] = $this->inprogressfeedback_model->get_AssignTo();
		$data['technician'] = $this->inprogressfeedback_model->get_Technician();
		$data['inProgressFeedbacks'] = $this->inprogressfeedback_model->get_feedbacks_record($UID);
		$data['replyFeedbacks'] = $this->inprogressfeedback_model->get_replyfeedbacks_record($UID);
		$feedRecord = $this->inprogressfeedback_model->get_feedbacks_record($UID);
		
		//set validation rules
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('Priority', 'Priority');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Feedbacks/InProgressFeedbacks/Detail',$data);
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Feedbacks/InProgressFeedbacks/Detail',$data);
			}
		}
		else
        {
			//validation succeed
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\feedback';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			$fileName1 = NULL;
			$fileName2 = NULL;
			$fileName3 = NULL;
			$fileName4 = NULL;

			if(!empty($_FILES['Attachment1'])){
				$fileName1 = date("Ymdhis").'_'.$_FILES["Attachment1"]['name'];
			}
			
			if(!empty($_FILES['Attachment2'])){
				$fileName2 = date("Ymdhis").'_'.$_FILES["Attachment2"]['name'];
			}
			
			if(!empty($_FILES['Attachment3'])){
				$fileName3 = date("Ymdhis").'_'.$_FILES["Attachment3"]['name'];
			}
			
			if(!empty($_FILES['Attachment4'])){
				$fileName4 = date("Ymdhis").'_'.$_FILES["Attachment4"]['name'];				
			}
			
			$priority = $this->input->post('Priority');
			if($priority == '0' || $priority == ''){
				$priority = $feedRecord[0]->Priority;
			}
			
			//complaint details
			$this->jompay->from('Feedback');
			$this->jompay->where('FeedbackID', $UID);
			$query = $this->jompay->get();
			$msg = $query->result();
			
			//get email of complainer
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $msg[0]->CreatedBy);
			$query = $this->cportal->get();
			$users = $query->result();
	
			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			//config
			$this->db->from('WebCtrl');
			$this->db->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->db->get();	
			$webctrl = $query->result();

			$configEmail = Array(
				'protocol' => 'smtp',
				'smtp_host' => trim($webctrl[0]->EMAILSERVER),
				'smtp_port' => trim($webctrl[0]->SERVERPORT),
				'smtp_user' => trim($webctrl[0]->AUTHUSER),
				'smtp_pass' => trim($webctrl[0]->AUTHPASSWORD),
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			//no file uploaded
			if($_FILES["Attachment1"]["error"] == 4){
				$insert = array(
					'IncidentType' => $msg[0]->IncidentType,
					'Description' => $this->input->post('Description'),
					'UserID' => $users[0]->USERID,
					'Priority' => $priority,
					'Status' => 'InProgress',
					'CStatusID' => '3',
					'ComplaintIDParent' => $UID,
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
					'CondoSeq' => $_SESSION['condoseq'],
					'Role' => $_SESSION['role'],
				);

				//send email
				if($_SESSION['role'] == 'Mgmt'){
					$message = "Dear ".trim($users[0]->PROPERTYNO).",".
							   "<br><br>Management office has respond to your feedback, please login to condo portal ".GLOBAL_WEB_URL." to view the respond.".
							   "<br><br>Feedback Id: ".$UID.
							   "<br>Subject: ".$msg[0]->Subject.
							   "<br>Priority: Medium".
							   "<br>Status: InProgress".
							   "<br><br>--".
							   "<br>".$_SESSION['formalname']." Management Office";
					$this->load->library('email', $configEmail);
					$this->email->set_newline("\r\n");
					$this->email->from($webctrl[0]->EMAILSENDER);
					$this->email->to(trim($users[0]->EMAIL));
					$this->email->subject('Complaint: '.$msg[0]->Subject);
					$this->email->message($message);
					$this->email->send();

					//insert record
					//$this->jompay->insert('Feedback', $insert);
					if ($this->jompay->insert('Feedback', $insert)) {
						//update priority status
						$this->jompay->set('Priority', $priority);
						$this->jompay->set('Status', 'InProgress');
						$this->jompay->set('CStatusID', '3');
						$this->jompay->where('FeedbackID', $UID);
						$this->jompay->update('Feedback');
					
						//display message
						$this->session->set_flashdata('reply', '<script language=javascript>alert("Feedback has been successfully sent!");</script>');
						redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
					}
					else{
						$error = $this->jompay->error();
						$this->session->set_flashdata('reply', '<script language=javascript>alert("'.$error['message'].'");</script>');
						redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
					}
				}
				else{
					$jsonData = array('UserTokenNo' => 'PIS7040S', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($users[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'], 
									  'RequestId' => $UID, 'Content' => $this->input->post('Description'));

					$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/RequestMessageAdd';
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
						else if($key == 'Result'){
							$RequestId = $value['RequestId'];
						}
					}

					if($Status == 'F'){
						$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
						redirect('index.php/Common/OpenFeedbacks/Index');
					}
					else{
						$this->session->set_flashdata('reply', '<script language=javascript>alert("Feedback has been successfully sent!");</script>');
						redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
					}
				}
			}
			else{
				$maxImg = 4;
				$img = 1;
				for ($img = 1; $img <= 4; $img++)
				{
					if(!empty($_FILES['Attachment'.$img]))
					{
						$config['file_name'] = date("Ymdhis").'_'.$_FILES['Attachment'.$img]['name'];
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('Attachment'.$img))
						{
							// case - failure
							$upload_error = array('error' => $this->upload->display_errors());
							$this->session->set_flashdata('msg','<script language=javascript>alert("'.$upload_error['error'].'");</script>');
							redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
						}
						else
						{
							// case - success
							$upload_data = $this->upload->data();
							//$this->thumb($upload_data,500,false);
						}
					}
				}
				
				$attachment_arr = array();

				if($fileName1 != NULL){
					$fileName1 = base_url().'application/uploads/feedback/'.$fileName1;
					$attachment_arr[] = ['Url' => $fileName1];
				}
				
				if($fileName2 != NULL){
					$fileName2 = base_url().'application/uploads/feedback/'.$fileName2;
					$attachment_arr[] = ['Url' => $fileName2];
				}
				
				if($fileName3 != NULL){
					$fileName3 = base_url().'application/uploads/feedback/'.$fileName3;
					$attachment_arr[] = ['Url' => $fileName3];
				}
				
				if($fileName4 != NULL){
					$fileName4 = base_url().'application/uploads/feedback/'.$fileName4;
					$attachment_arr[] = ['Url' => $fileName4];
				}
				
				$insert = array(
					'IncidentType' => $msg[0]->IncidentType,
					'Description' => $this->input->post('Description'),
					'UserID' => $users[0]->USERID,
					'Attachment1' => $fileName1,
					'Attachment2' => $fileName2,
					'Attachment3' => $fileName3,
					'Attachment4' => $fileName4,
					'Priority' => $priority,
					'Status' => 'InProgress',
					'CStatusID' => '3',
					'ComplaintIDParent' => $UID,
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
					'CondoSeq' => $_SESSION['condoseq'],
					'Role' => $_SESSION['role'],
				);

				//send email
				if($_SESSION['role'] == 'Mgmt'){
					$message = "Dear ".trim($users[0]->PROPERTYNO).",".
							   "<br><br>Management office has respond to your feedback, please login to condo portal ".GLOBAL_WEB_URL." to view the respond.".
							   "<br><br>Feedback Id: ".$UID.
							   "<br>Subject: ".$msg[0]->Subject.
							   "<br>Priority: Medium".
							   "<br>Status: InProgress".
							   "<br><br>--".
							   "<br>".$_SESSION['formalname']." Management Office";
					$this->load->library('email', $configEmail);
					$this->email->set_newline("\r\n");
					$this->email->from($webctrl[0]->EMAILSENDER);
					$this->email->to(trim($users[0]->EMAIL));
					$this->email->subject('Complaint: '.$msg[0]->Subject);
					$this->email->message($message);
					$this->email->send();

					//insert record
					//$this->jompay->insert('Feedback', $insert);
					
					if ($this->jompay->insert('Feedback', $insert)) {
						//update priority status
						$this->jompay->set('Priority', $priority);
						$this->jompay->set('Status', 'InProgress');
						$this->jompay->set('CStatusID', '3');
						$this->jompay->where('FeedbackID', $UID);
						$this->jompay->update('Feedback');
			
						$this->session->set_flashdata('reply', '<script language=javascript>alert("Feedback has been successfully sent!");</script>');
						redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
					}
					else{
						$error = $this->jompay->error();
						$this->session->set_flashdata('reply', '<script language=javascript>alert("'.$error['message'].'");</script>');
						redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
					}
				}
				else{
					$jsonData = array('UserTokenNo' => 'PIS7040S', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($users[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'], 
									  'RequestId' => $UID, 'Content' => $this->input->post('Description'));

					$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/RequestMessageAdd';
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
						else if($key == 'Result'){
							$RequestId = $value['RequestId'];
						}
					}

					if($Status == 'F'){
						$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
						redirect('index.php/Common/OpenFeedbacks/Index');
					}
					else{
						$this->session->set_flashdata('reply', '<script language=javascript>alert("Feedback has been successfully sent!");</script>');
						redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
					}
				}
			}
        }
	}
	
	function thumb($data,$thumb_size,$create_thumb)    
	{       
		//$config['image_library'] = 'gd2';    
		$config['source_image'] = $data['full_path'];      
		$config['create_thumb'] = $create_thumb;       
		$config['width'] = $thumb_size;
		$config['height'] = $thumb_size;     
		$this->load->library('image_lib', $config);    
		$this->image_lib->resize();
	}
	
	public function Close($UID)
	{
		//call the model
		$data['UID'] = $UID;
		$data['company'] = $this->header_model->get_Company();
		$data['inProgressFeedbacks'] = $this->inprogressfeedback_model->get_feedbacks_record($UID);
		$data['replyFeedbacks'] = $this->inprogressfeedback_model->get_feedbacks_replied($UID);
		
		//set validation rules
        $this->form_validation->set_rules('CompletedDate', 'CompletedDate', 'callback_combo_check');
        $this->form_validation->set_rules('Technician', 'Technician');
		$this->form_validation->set_rules('Remarks', 'Remarks');
        
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Feedbacks/InProgressFeedbacks/Detail',$data);
			}
		}
		else
        {
			//validation succeed
			//rearrange date
			$date = $this->input->post('CompletedDate');
			if($date != ''){
				$temp = explode('/', $this->input->post('CompletedDate'));
				$completedDate = $temp[2].'-'.$temp[1].'-'.$temp[0].' '.date('H:i:s');
			}
			else{
				$completedDate = date('Y-m-d H:i:s');
			}

			if($this->input->post('Technician') != '' && $this->input->post('Technician') != '0')
			{
				$technician = $this->input->post('Technician');
			}
			else
			{
				$technician = $_SESSION['username'];
			}
			
            //complaint details
			$this->jompay->from('Feedback');
			$this->jompay->where('FeedbackID', $UID);
			$query = $this->jompay->get();
			$msg = $query->result();
			
			//get email of complainer
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $msg[0]->CreatedBy);
			$query = $this->cportal->get();
			$users = $query->result();
			
			//config
			$this->db->from('WebCtrl');
			$this->db->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->db->get();	
			$webctrl = $query->result();

			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => trim($webctrl[0]->EMAILSERVER),
				'smtp_port' => trim($webctrl[0]->SERVERPORT),
				'smtp_user' => trim($webctrl[0]->AUTHUSER),
				'smtp_pass' => trim($webctrl[0]->AUTHPASSWORD),
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$message = "Dear ".trim($users[0]->PROPERTYNO).",".
					   "<br><br>This is to notify status of feedback ID#".$UID." is Closed. We believe you are satisfied and case has been resolved.".
					   "<br><br>Feedback Id: ".$UID.
					   "<br>Subject: ".$msg[0]->Subject.
					   "<br>Priority: Medium".
					   "<br>Status: Closed".
					   "<br><br>--".
					   "<br>".$_SESSION['formalname']." Management Office";
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($webctrl[0]->EMAILSENDER);
			$this->email->to(trim($users[0]->EMAIL));
			$this->email->subject('Complaint: '.$msg[0]->Subject);
			$this->email->message($message);
			$this->email->send();
			
			$data = array(
                'CompletedDate' => $completedDate,
				'CompletedBy' => $technician,
				'ManagementRemarks' => $this->input->post('Remarks'),
				'Status' => 'Closed',
				'CStatusID' => '2',
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
				'CondoSeq' => $_SESSION['condoseq'],
            );

			//update record
            $this->jompay->where('FeedbackID', $UID);
            $this->jompay->update('Feedback', $data);
			
			//update status
			$this->jompay->set('Status', 'Closed');
			$this->jompay->set('CStatusID', '2');
			$this->jompay->where('ComplaintIDParent', $UID);
			$this->jompay->update('Feedback');
			
			if($this->input->post('Amount') != ''){
				$log = array(
					'FeedbackID' => $UID,
					'PropertyNo' => $this->input->post('propNo'),
					'Amount' => $this->input->post('Amount'),
					'Description' => $this->input->post('Desc'),
					'CondoSeq' => $_SESSION['condoseq'],
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
				);
				
				//insert record
				$this->db->insert('FeedbackLog', $log);
			}

            //display message
            $this->session->set_flashdata('close', '<script language=javascript>alert("PropertyNo: '.$this->input->post('propNo').'\nSubject: '.$msg[0]->Subject.'\nComplaint has been closed.");</script>');
            redirect('index.php/Common/ClosedFeedbacks/Detail/'.$UID);
        }
	}
	
	function SendMail($UID)
	{
		//call the model
		$feedRecord = $this->inprogressfeedback_model->get_feedbacks_record($UID);
		$company = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('Priority', 'Priority', 'required');
        $this->form_validation->set_rules('AssignTo', 'AssignTo', 'required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			redirect('index.php/Common/InProgressFeedbacks/Detail/' . $UID);
		}
		else
        {
			$technician = explode(",", $this->input->post('AssignTo'));
			$remarks = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $this->input->post('AssignTo'))));

			$priority = $this->input->post('Priority');
			if($priority == '0'){
				$priority = $feedRecord[0]->Priority;
			}
			
			//validation succeed
            $data = array(
				'PropertyNo' => $this->input->post('PropertyNo'),
				'Description' => $this->input->post('Description'),
				'Priority' => $priority,
				'Status' => 'InProgress',
				'ComplaintIDParent' => $UID,
				'ResponseBy' => $_SESSION['username'],
				'ResponseDate' => date('Y-m-d H:i:s'),
				'ForwardTo' => $technician[0],
				'ForwardDate' => date('Y-m-d H:i:s'),
				'CondoSeq' => $_SESSION['condoseq'],
				'Role' => $_SESSION['role'],
            );
			
			//complaint details
			$this->jompay->from('Feedback');
			$this->jompay->where('FeedbackID', $UID);
			$query = $this->jompay->get();
			$msg = $query->result();

			//config
			$this->db->from('WebCtrl');
			$this->db->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->db->get();	
			$webctrl = $query->result();

			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => trim($webctrl[0]->EMAILSERVER),
				'smtp_port' => trim($webctrl[0]->SERVERPORT),
				'smtp_user' => trim($webctrl[0]->AUTHUSER),
				'smtp_pass' => trim($webctrl[0]->AUTHPASSWORD),
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$message = "Complaint Subject: ".$msg[0]->Subject.
					   "<br><br>Complaint Details: ".$msg[0]->Description.
					   "<br><br>Management Instruction: ".$this->input->post('Description').
					   "<br><br>Please login to proceed with this issue. <a href='".base_url()."index.php/Common/OpenFeedbacks/Detail/".$UID."'>Complaint Subject: ".$msg[0]->Subject."</a>";
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($webctrl[0]->EMAILSENDER);
			$this->email->to(array(trim($technician[1])));
			$this->email->subject('Feedbacks/Requests for Unit No: '.trim($this->input->post('PropertyNo')).' of '.$company[0]->CompanyName);
			$this->email->message($message);
			$this->email->send();

			//insert record
			$this->jompay->insert('Feedback', $data);
			
			//update priority status
			$this->jompay->set('Priority', $priority);
			$this->jompay->set('Status', 'InProgress');
			$this->jompay->where('FeedbackID', $UID);
			$this->jompay->update('Feedback');
			
			//display message
			$this->session->set_flashdata('email', '<script language=javascript>alert("Email successfully sent to '.trim($technician[0]).'");</script>');
			redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
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
}?>
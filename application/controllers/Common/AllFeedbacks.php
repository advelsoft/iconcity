<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class allfeedbacks extends CI_Controller {
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
		
		//load the model
		$this->load->model('allfeedback_model');
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
        $fbList = $this->allfeedback_model->get_feedbacks_list();
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
													 'feedbackID'=>$file['feedbackID']);
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
        $config['base_url'] = base_url()."index.php/Common/AllFeedbacks/Index";
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
			$this->load->view('Mgmt/Feedbacks/AllFeedbacks/Index',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Feedbacks/AllFeedbacks/Index',$data);
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['priority'] = $this->allfeedback_model->get_Priority();
		$data['assignTo'] = $this->allfeedback_model->get_AssignTo();
		$data['technician'] = $this->allfeedback_model->get_Technician();
		$data['department'] = $this->allfeedback_model->get_Department();

		//set validation rules
        $this->form_validation->set_rules('IncidentType', 'IncidentType', 'callback_combo_check');
        $this->form_validation->set_rules('Subject', 'Subject', 'required');
        $this->form_validation->set_rules('Description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'User'){
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/Feedbacks/AllFeedbacks/Create', $data);
				$this->load->view('User/footer');
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
			
			//no file uploaded
			if($_FILES["Attachment1"]["error"] == 4){ 
				$insert = array(
					'IncidentType' => $this->input->post('IncidentType'),
					'Subject' => $this->input->post('Subject'),
					'Description' => $this->input->post('Description'),
					'PropertyNo' => $_SESSION['propertyno'],
					'Priority' => 'Medium',
					'Status' => 'Open',
					'CondoSeq' => GLOBAL_CONDOSEQ,
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
				);
			}
			else{
				$maxImg = 4;
				$img = 1;
				for ($img = 1; $img <= 4; $img++)
				{
					if(!empty($_FILES['Attachment'.$img])){
						$config['file_name'] = date("Ymdhis").'_'.$_FILES['Attachment'.$img]['name'];
						$this->upload->initialize($config);
					}

					if (!$this->upload->do_upload('Attachment'.$img))
					{
						// case - failure
						$upload_error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('msg','<script language=javascript>alert("'.$upload_error['error'].'");</script>');
						redirect('index.php/Common/AllFeedbacks/Create');
					}
					else
					{
						// case - success
						$upload_data = $this->upload->data();
						
						$this->thumb($upload_data,500,false);

						$insert = array(
							'IncidentType' => $this->input->post('IncidentType'),
							'Subject' => $this->input->post('Subject'),
							'Description' => $this->input->post('Description'),
							'PropertyNo' => $_SESSION['propertyno'],
							'Attachment1' => $fileName1,
							'Attachment2' => $fileName2,
							'Attachment3' => $fileName3,
							'Attachment4' => $fileName4,
							'Priority' => 'Medium',
							'Status' => 'Open',
							'CondoSeq' => GLOBAL_CONDOSEQ,
							'CreatedBy' => $_SESSION['userid'],
							'CreatedDate' => date('Y-m-d H:i:s'),
						);
					}
				}
			}

			//send email
			//get email of complainer
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$users = $query->result();

			//config
			$this->db->from('WebCtrl');
			$this->db->where('CONDOSEQ', GLOBAL_CONDOSEQ);
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

			$message = "Dear ".$users[0]->OWNERNAME."<br><br>We have received your complaint.<br><br>From The Management Office";
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($webctrl[0]->EMAILSENDER);
			$this->email->to(trim($users[0]->EMAIL));
			$this->email->subject('Complaint: '.trim($this->input->post('Subject')));
			$this->email->message($message);
			if($this->email->send())
			{	
				//insert record
				$this->db->insert('Feedback', $insert);
			
				//display message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Complaint sent.");</script>');
				redirect('index.php/Common/AllFeedbacks/Create');
			}
			else
			{
				//show_error($this->email->print_debugger());
				//display message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Complaint sent.");</script>');
				redirect('index.php/Common/AllFeedbacks/Create');
			}
        }
	}
	
	public function Detail($UID)
	{
		//call the model
		$data['UID'] = $UID;
		$data['company'] = $this->header_model->get_Company();
		$data['priority'] = $this->allfeedback_model->get_Priority();
		$data['assignTo'] = $this->allfeedback_model->get_AssignTo();
		$data['technician'] = $this->allfeedback_model->get_Technician();
		$data['allFeedbacks'] = $this->allfeedback_model->get_feedbacks_record($UID);
		$data['replyFeedbacks'] = $this->allfeedback_model->get_replyfeedbacks_record($UID);
		$feedRecord = $this->allfeedback_model->get_feedbacks_record($UID);
		$company = $this->header_model->get_Company();
		
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
				$this->load->view('Mgmt/Feedbacks/AllFeedbacks/Detail',$data);
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Feedbacks/AllFeedbacks/Detail',$data);
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
			if($priority == '0'){
				$priority = $feedRecord[0]->Priority;
			}
			
			//no file uploaded
			if($_FILES["Attachment1"]["error"] == 4){
				$insert = array(
					'Description' => $this->input->post('Description'),
					'PropertyNo' => $this->input->post('propNo'),
					'Priority' => $priority,
					'Status' => 'InProgress',
					'ComplaintIDParent' => $UID,
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
					'CondoSeq' => GLOBAL_CONDOSEQ,
				);

				//send email
				if($_SESSION['role'] == 'Mgmt'){
					//complaint details
					$this->db->from('Feedback');
					$this->db->where('FeedbackID', $UID);
					$query = $this->db->get();
					$msg = $query->result();
					
					//get email of complainer
					$this->cportal->from('Users');
					$this->cportal->where('PropertyNo', $this->input->post('propNo'));
					$query = $this->cportal->get();
					$users = $query->result();

					//config
					$this->db->from('WebCtrl');
					$this->db->where('CONDOSEQ', GLOBAL_CONDOSEQ);
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
							   "<br><br>Management Reply: ".$this->input->post('Description');
					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");
					$this->email->from($webctrl[0]->EMAILSENDER);
					$this->email->to(trim($users[0]->EMAIL));
					$this->email->subject('Feedbacks/Requests for Unit No: '.trim($this->input->post('propNo')).' of '.$company[0]->CompanyName);
					$this->email->message($message);
					if($this->email->send())
					{	
						//insert record
						$this->db->insert('Feedback', $insert);

						//update priority status
						$this->db->set('Priority', $priority);
						$this->db->set('Status', 'InProgress');
						$this->db->where('FeedbackID', $UID);
						$this->db->update('Feedback');

						//display message
						$this->session->set_flashdata('reply', '<script language=javascript>alert("Feedback has been successfully sent!");</script>');
						redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
					}
					else
					{
						//show_error($this->email->print_debugger());
						//display message
						$this->session->set_flashdata('email', '<script language=javascript>alert("Email failed to send. Please contact administrator.");</script>');
						redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
					}
				}
				else{
					//display message
					$this->session->set_flashdata('reply', '<script language=javascript>alert("Feedback has been successfully sent!");</script>');
					redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
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
					}
					
					if (!$this->upload->do_upload('Attachment'.$img))
					{
						// case - failure
						$upload_error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('msg','<script language=javascript>alert("'.$upload_error['error'].'");</script>');
						redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
					}
					else
					{
						// case - success
						$upload_data = $this->upload->data();

						$this->thumb($upload_data,500,false);

						$insert = array(
							'Description' => $this->input->post('Description'),
							'PropertyNo' => $this->input->post('propNo'),
							'Attachment1' => $fileName1,
							'Attachment2' => $fileName2,
							'Attachment3' => $fileName3,
							'Attachment4' => $fileName4,
							'Priority' => $priority,
							'Status' => 'InProgress',
							'ComplaintIDParent' => $UID,
							'CreatedBy' => $_SESSION['userid'],
							'CreatedDate' => date('Y-m-d H:i:s'),
							'CondoSeq' => GLOBAL_CONDOSEQ,
						);

						//send email
						if($_SESSION['role'] == 'Mgmt'){
							//complaint details
							$this->db->from('Feedback');
							$this->db->where('FeedbackID', $UID);
							$query = $this->db->get();
							$msg = $query->result();

							//get email of complainer
							$this->cportal->from('Users');
							$this->cportal->where('PropertyNo', $this->input->post('propNo'));
							$query = $this->cportal->get();
							$users = $query->result();

							//config
							$this->db->from('WebCtrl');
							$this->db->where('CONDOSEQ', GLOBAL_CONDOSEQ);
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
									   "<br><br>Management Reply: ".$this->input->post('Description');
							$this->load->library('email', $config);
							$this->email->set_newline("\r\n");
							$this->email->from($webctrl[0]->EMAILSENDER);
							$this->email->to(trim($users[0]->EMAIL));
							$this->email->subject('Feedbacks/Requests for Unit No: '.trim($this->input->post('propNo')).' of '.$company[0]->CompanyName);
							$this->email->message($message);
							if($this->email->send())
							{	
								//insert record
								$this->db->insert('Feedback', $insert);

								//update priority status
								$this->db->set('Priority', $priority);
								$this->db->set('Status', 'InProgress');
								$this->db->where('FeedbackID', $UID);
								$this->db->update('Feedback');

								//display message
								$this->session->set_flashdata('reply', '<script language=javascript>alert("Feedback has been successfully sent!");</script>');
								redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
							}
							else
							{
								//show_error($this->email->print_debugger());
								//display message
								$this->session->set_flashdata('email', '<script language=javascript>alert("Email failed to send. Please contact administrator.");</script>');
								redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
							}
						}
						else{
							//display message
							$this->session->set_flashdata('reply', '<script language=javascript>alert("Feedback has been successfully sent!");</script>');
							redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
						}
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
		$data['allFeedbacks'] = $this->allfeedback_model->get_feedbacks_record($UID);
		$data['replyFeedbacks'] = $this->allfeedback_model->get_feedbacks_replied($UID);
		
		//set validation rules
        $this->form_validation->set_rules('CompletedDate', 'CompletedDate', 'callback_combo_check');
        $this->form_validation->set_rules('Technician', 'Technician', 'required');
        
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Feedbacks/AllFeedbacks/Detail',$data);
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Feedbacks/AllFeedbacks/Detail',$data);
			}
		}
		else
        {
			//validation succeed
			//rearrange date
			$temp = explode('/', $this->input->post('CompletedDate'));
			$completedDate = $temp[2].'-'.$temp[1].'-'.$temp[0];
			
            $data = array(
                'CompletedDate' => $completedDate.' '.date('H:i:s'),
				'CompletedBy' => $this->input->post('Technician'),
				'Status' => 'Closed',
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
				'CondoSeq' => GLOBAL_CONDOSEQ,
            );

			//update record
            $this->db->where('FeedbackID', $UID);
            $this->db->update('Feedback', $data);
			
			//update status
			$this->db->set('Status', 'Closed');
			$this->db->where('ComplaintIDParent', $UID);
			$this->db->update('Feedback');
			
			if($this->input->post('Amount') != ''){
				$log = array(
					'FeedbackID' => $UID,
					'PropertyNo' => $this->input->post('propNo'),
					'Amount' => $this->input->post('Amount'),
					'Description' => $this->input->post('Desc'),
					'CondoSeq' => GLOBAL_CONDOSEQ,
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
				);
				
				//insert record
				$this->db->insert('FeedbackLog', $log);
			}
			
			//complaint details
			$this->db->from('Feedback');
			$this->db->where('FeedbackID', $UID);
			$query = $this->db->get();
			$msg = $query->result();

            //display message
            $this->session->set_flashdata('close', '<script language=javascript>alert("PropertyNo: '.$this->input->post('propNo').'\nSubject: '.$msg[0]->Subject.'\nComplaint has been closed.");</script>');
            redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
        }
	}
	
	function SendMail($UID)
	{
		//call the model
		$feedRecord = $this->allfeedback_model->get_feedbacks_record($UID);
		$company = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('Priority', 'Priority', 'required');
        $this->form_validation->set_rules('AssignTo', 'AssignTo', 'required');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
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
				'ManagementRemarks' => $remarks,
				'Description' => 'Forward To:'.$this->input->post('Description'),
				'Priority' => $priority,
				'Status' => 'InProgress',
				'ComplaintIDParent' => $UID,
				'CreatedBy' => $_SESSION['userid'],
				'CreatedDate' => date('Y-m-d H:i:s'),
				'CondoSeq' => GLOBAL_CONDOSEQ,
            );

			//complaint details
			$this->db->from('Feedback');
			$this->db->where('FeedbackID', $UID);
			$query = $this->db->get();
			$msg = $query->result();
			
			//config
			$this->db->from('WebCtrl');
			$this->db->where('CONDOSEQ', GLOBAL_CONDOSEQ);
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

			echo $message = "Complaint Subject: ".$msg[0]->Subject.
					   "<br><br>Complaint Details: ".$msg[0]->Description.
					   "<br><br>Management Instruction: ".$this->input->post('Description').
					   "<br><br>Please check to login to proceed. <a href='".base_url()."'>".$company[0]->CompanyName."</a>";
					   //<a href='".base_url()."index.php/Common/AllFeedbacks/Detail/".$UID."'>".$company[0]->CompanyName."</a>";
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($webctrl[0]->EMAILSENDER);
			$this->email->to(array(trim($technician[1])));
			$this->email->subject('Feedbacks/Requests for Unit No: '.trim($this->input->post('PropertyNo')).', Status: '.$priority);
			$this->email->message($message);
			if($this->email->send())
			{
				//insert record
				$this->db->insert('Feedback', $data);
				
				//update priority status
				$this->db->set('Priority', $priority);
				$this->db->set('Status', 'InProgress');
				$this->db->where('FeedbackID', $UID);
				$this->db->update('Feedback');
				
				//display message
				$this->session->set_flashdata('email', '<script language=javascript>alert("Email successfully sent to '.trim($technician[0]).'");</script>');
				redirect('index.php/Common/InProgressFeedbacks/Detail/'.$UID);
			}
			else
			{
				//show_error($this->email->print_debugger());
				//display message
				$this->session->set_flashdata('email', '<script language=javascript>alert("Email failed to send. Please contact administrator.");</script>');
				redirect('index.php/Common/AllFeedbacks/Detail/'.$UID);
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
}?>
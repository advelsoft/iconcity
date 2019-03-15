<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class technician extends CI_Controller {
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
		$this->load->helper('email');
		$this->load->library('pagination');
		
		//load the model
		$this->load->model('technician_model');
		$this->load->model('header_model');
		
		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Index($page=1)
	{		
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $techList = $this->technician_model->get_tech_list();
        $data['techList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($techList) > 0) {
            $paginatedFiles = array_slice($techList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['techList'][] = array('loginID'=>$file['loginID'],
											'name'=>$file['name'],
											'createdBy'=>$file['createdBy'],
											'createdDate'=>$file['createdDate'],
											'modifiedBy'=>$file['modifiedBy'],
											'modifiedDate'=>$file['modifiedDate'],
											'userID'=>$file['userID']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Technician/Index";
        $config['total_rows'] = count($techList);
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
			//load the view
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Technician/Index',$data);
		}
	}
	
	public function Create()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['name'] = $this->technician_model->get_Name();
		$company = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('LoginID', 'LoginID', 'trim|required');
		//$this->form_validation->set_rules('LoginPassword', 'LoginPassword', 'trim|required');
        $this->form_validation->set_rules('Name', 'Name', 'callback_combo_check');
        $this->form_validation->set_rules('Email', 'Email', 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Technician/Create',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			//get Condo Name
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', GLOBAL_CONDOSEQ);
			$query = $this->jompay->get();
			$result = $query->result();
			
			//check if exist
			$this->db->from('Users');
			$this->db->where('Name', $this->input->post('Name'));
			$query = $this->db->get();
			$exist = $query->result();
			
			if(count($exist) == 0){
				//send email
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
				
				//generate random characters
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < 8; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}

				$message = "Dear ".$this->input->post('Name').",".
						   "<br><br>We have registered your login details. Please login to ".base_url()." web portal using this details.".
						   "<br><br>LoginID: ".$this->input->post('LoginID').
						   "<br>Password: ".$randomString.
						   "<br><br>Please change your password once you login.".
						   "<br><br>From The Management Office";
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from($webctrl[0]->EMAILSENDER);
				$this->email->to($this->input->post('Email'));
				$this->email->subject('Registration for '.$company[0]->CompanyName);
				$this->email->message($message);
				if($this->email->send())
				{	
					$data = array(
						'LoginID' => $this->input->post('LoginID'),
						'LoginPassword' => $randomString,
						'Name' => $this->input->post('Name'),
						'Email' => $this->input->post('Email'),
						'Phone' => $this->input->post('Phone'),
						'Role' => 'Tech',
						'CreatedBy' => $_SESSION['userid'],
						'CreatedDate' => date('Y-m-d H:i:s'),
						'CondoSeq' => GLOBAL_CONDOSEQ,
						'CondoName' => $result[0]->DESCRIPTION,
					);

					//insert record
					$this->db->insert('Users', $data);
					
					//display message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$this->input->post('Name').' has been created and email with login details has been sent.");</script>');
					redirect('index.php/Common/Technician/Index');
				}
				else
				{
					//show_error($this->email->print_debugger());
					//display message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Email failed to send. Please contact administrator.");</script>');
					redirect('index.php/Common/Technician/Create');
				}
			}
			else{
				$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$this->input->post('Name').' already exist");</script>');
				redirect('index.php/Common/Technician/Index');
			}
		}
	}
	
	public function Detail($UserID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['techRecord'] = $this->technician_model->get_tech_record($UserID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Technician/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
	public function Update($UserID)
	{
		//call the model function to get the data
		$data['UserID'] = $UserID;
		$data['company'] = $this->header_model->get_Company();
		$data['techRecord'] = $this->technician_model->get_tech_record($UserID);
		$data['name'] = $this->technician_model->get_Name();
		
		//set validation rules
        $this->form_validation->set_rules('LoginID', 'LoginID', 'trim|required');
		//$this->form_validation->set_rules('LoginPassword', 'LoginPassword', 'trim|required');
        $this->form_validation->set_rules('Name', 'Name', 'callback_combo_check|required');
        $this->form_validation->set_rules('Email', 'Email', 'trim'); 
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Technician/Update',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			//get Condo Name
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', GLOBAL_CONDOSEQ);
			$query = $this->jompay->get();
			$result = $query->result();
			
			//check if exist
			$this->db->from('Users');
			$this->db->where('Name', $this->input->post('Name'));
			$query = $this->db->get();
			$exist = $query->result();
			
			if(count($exist) == 0){
				//send email
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
				
				//generate random characters
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < 8; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}

				$message = "Dear ".$this->input->post('Name').",".
						   "<br><br>We have updated your login details. Please login to ".$company[0]->CompanyName." web portal using this details.".
						   "<br><br>LoginID: ".$this->input->post('LoginID').
						   "<br><br>Password: ".$randomString.
						   "<br><br>From The Management Office";
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from($webctrl[0]->EMAILSENDER);
				$this->email->to($this->input->post('Email'));
				$this->email->subject('Registration for '.$company[0]->CompanyName);
				$this->email->message($message);
				if($this->email->send())
				{	
					$data = array(
						'LoginID' => $this->input->post('LoginID'),
						'Name' => $this->input->post('Name'),
						'Email' => $this->input->post('Email'),
						'Phone' => $this->input->post('Phone'),
						'ModifiedBy' => $_SESSION['userid'],
						'ModifiedDate' => date('Y-m-d H:i:s'),
					);

					//update record
					$this->db->where('UserID', $UserID);
					$this->db->update('Users', $data);
					
					//display message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Email has been sent.");</script>');
					redirect('index.php/Common/Technician/Index');
				}
				else
				{
					//show_error($this->email->print_debugger());
					//display message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Email failed to send. Please contact administrator.");</script>');
					redirect('index.php/Common/Technician/Create');
				}
			}
			else{
				$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$this->input->post('Name').' already exist");</script>');
				redirect('index.php/Common/Technician/Index');
			}
		}
	}
	
	public function Delete($UserID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['techRecord'] = $this->technician_model->get_tech_record($UserID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Technician/Delete',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
    function delete_record($UserID)
    {
        //delete record
        $this->db->where('UserID', $UserID);
        $this->db->delete('Users');
        redirect('index.php/Common/Technician/Index');
    }
	
	public function Email() 
	{
		//call the model
		$name = $_GET['name'];
		$data['emails'] = $this->technician_model->get_tech_email($name);
		
		//load the view
		$this->load->view('Mgmt/Setup/Technician/UserTech', $data);
	}
	
	public function ResetPw($UserID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['techRecord'] = $this->technician_model->get_tech_record($UserID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Technician/ResetPw',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
	function reset_password($UserID)
	{
		$company = $this->header_model->get_Company();
		
		//generate random characters
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 8; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		$user = $this->technician_model->get_tech_record($UserID);

		if(valid_email($user[0]->Email)){
			$log = array(
				'OldLoginID' => $user[0]->LoginID,
				'OldPassword' => $user[0]->LoginPassword,
				'NewPassword' => $randomString,
				'CreatedDate' => date('Y-m-d H:i:s'),
			);

			//send email
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

			$message = "Dear ".$user[0]->Name.",".
					   "<br><br>We have reset your password. Please login to ".base_url()." web portal using this details.".
					   "<br><br>LoginID: ".$user[0]->LoginID.
					   "<br>Password: ".$randomString.
					   "<br><br>Please change your password once you login.".
					   "<br><br>From The Management Office";
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($webctrl[0]->EMAILSENDER);
			$this->email->to($user[0]->Email);
			$this->email->subject('Reset Password for '.$company[0]->CompanyName);
			$this->email->message($message);
			if($this->email->send())
			{	
				//insert record
				$this->db->insert('ChangeProfileLog', $log);

				//update record
				$this->db->set('LOGINPASSWORD', $randomString);
				$this->db->where('LOGINID', $user[0]->LoginID);
				$this->db->update('Users');

				//display message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("New password has sent to '.$user[0]->LoginID.'.");</script>');
				redirect('index.php/Common/Technician/Index');
			}
			else
			{
				//show_error($this->email->print_debugger());
				//display message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Email failed to send. Please contact administrator.");</script>');
				redirect('index.php/Common/Technician/Index');
			}
		}
		else{
			//display message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Email not enter for user. Please contact administrator.");</script>');
			redirect('index.php/Common/Technician/Index');
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
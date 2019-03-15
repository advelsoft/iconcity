<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class internetprovider extends CI_Controller {
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
		
		//load the model
		$this->load->model('promotion_model');
		$this->load->model('header_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function PackageSumm($CondoSeq)
	{
		//call the model
		$data['condoSeq'] = $CondoSeq;
		$data['company'] = $this->header_model->get_Company();
		$data['provider'] = $this->input->post('provider');
		$data['package'] = $this->input->post('package');
		
		//set validation rules
        $this->form_validation->set_rules('provider', 'provider', 'trim|required');
        $this->form_validation->set_rules('package', 'package', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			//load the view
			if($_SESSION['role'] == 'Admin'){
				//no view
			}
			else if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$data_view = array(
					"tab1" => $this->load->view('Mgmt/Promotion/InternetProvider/Maxis', $data, TRUE),
					"tab2" => $this->load->view('Mgmt/Promotion/InternetProvider/Unifi', $data, TRUE),
					"tab3" => $this->load->view('Mgmt/Promotion/InternetProvider/Time', $data, TRUE)
				);
				$this->load->view('Mgmt/Promotion/Internet',$data_view);
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$data_view = array(
					"tab1" => $this->load->view('User/Promotion/InternetProvider/Maxis', $data, TRUE),
					"tab2" => $this->load->view('User/Promotion/InternetProvider/Unifi', $data, TRUE),
					"tab3" => $this->load->view('User/Promotion/InternetProvider/Time', $data, TRUE)
				);
				$this->load->view('User/Promotion/InternetProvider/Index',$data_view);
			}
        }
        else
        {
			//load the view
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Promotion/InternetProvider/Confirmation', $data);
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Promotion/InternetProvider/Confirmation', $data);
			}
		}
	}
	
	public function Store($CondoSeq)
	{
		//call the model
		$data['condoSeq'] = $CondoSeq;
		
		//set validation rules
        $this->form_validation->set_rules('Phone', 'Phone', 'trim');
        $this->form_validation->set_rules('Email', 'Email', 'trim');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Promotion/InternetProvider/Confirmation');
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Promotion/InternetProvider/Confirmation');
			}
        }
        else
        {
			//get user detail
			if($_SESSION['role'] == 'Mgmt'){
				$this->db->where('UserID', $_SESSION['userid']);
				$this->db->from('Users');
				$query = $this->db->get();
				$user = $query->result();

				$propNo = $user[0]->LoginID;
				$name = $user[0]->Name;
			}
			else{
				$this->cportal->where('UserID', $_SESSION['userid']);
				$this->cportal->from('Users');
				$query = $this->cportal->get();
				$user = $query->result();

				$propNo = $user[0]->PROPERTYNO;
				$name = $user[0]->OWNERNAME;
			}
			
			$data = array(
				'Provider' => $this->input->post('provider'),
				'Package' => $this->input->post('package'),
				'PropertyNo' => $propNo,
				'OwnerName' => $name,
				'Email' => $this->input->post('Email'),
				'Phone' => $this->input->post('Phone'),
				'CreatedBy' => $_SESSION['userid'],
				'CreatedDate' => date('Y-m-d H:i:s'),
				'CondoSeq' => $CondoSeq,
			);
			
			//send email
			//condo
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $CondoSeq);
			$query = $this->jompay->get();	
			$condo = $query->result();

			//config
			$this->db->from('WebCtrl');
			$this->db->where('CONDOSEQ', $CondoSeq);
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

			$message = "This message submitted at ".date('Y-m-d g:i A').
					   "<br><br>Condo Name: ".$condo[0]->DESCRIPTION.
					   "<br>Unit No: ".$propNo.
					   "<br>Name: ".$name.
					   "<br>Phone: ".$this->input->post('Phone').
					   "<br>Email: ".$this->input->post('Email').
					   "<br><br>-----------------------------------------------------".
					   "<br>Internet Provider: ".$this->input->post('provider').
					   "<br>Package: ".$this->input->post('package').
					   "<br>-----------------------------------------------------";
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($webctrl[0]->EMAILSENDER);
			$this->email->to(trim($this->input->post('Email')));
			$this->email->subject('Request for Internet Provider');
			$this->email->message($message);
			if($this->email->send())
			{	
				//insert record
				$this->db->insert('InternetProvider', $data);

				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("You request has been sent to respectively internet provider");</script>');
				redirect('index.php/Common/Promotion/InternetProvider/'.$CondoSeq);
			}
			else
			{
				//show_error($this->email->print_debugger());
				//display message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("You request has been sent to respectively internet provider");</script>');
				redirect('index.php/Common/Promotion/InternetProvider/'.$CondoSeq);
			}
        }
	}
}?>
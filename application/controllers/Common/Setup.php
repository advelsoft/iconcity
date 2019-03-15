<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class setup extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//load the model
		$this->load->model('setup_model');
		$this->load->model('header_model');
		$this->cportal = $this->load->database('cportal',TRUE);

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Lists()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['condoList'] = $this->setup_model->get_condo_list();
		
		//load the view
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav');
		$this->load->view('Admin/Setup/ServerSetup/List',$data);
		$this->load->view('Admin/footer');
	}
	
	public function ServerSetup($CondoSeq)
	{
		//call the model
		$data['CondoSeq'] = $CondoSeq;
		$data['company'] = $this->header_model->get_Company();
		$data['setupList'] = $this->setup_model->get_setup_list($CondoSeq);
		$data['jompay'] = $this->setup_model->get_jompay();
		
		if($_SESSION['role'] == 'Admin'){
			//load the view
			$data_view = array(
				"tab1" => $this->load->view('Admin/Setup/ServerSetup/Email', $data, TRUE),
				"tab2" => $this->load->view('Admin/Setup/ServerSetup/SendPasswordText', $data, TRUE),
				"tab3" => $this->load->view('Admin/Setup/ServerSetup/JomPay', $data, TRUE)
			);
			
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/ServerSetup/ServerSetup',$data_view);
			$this->load->view('Admin/footer');
		}
	}
	
	public function EmailSetup($CondoSeq)
	{
		//set validation rules
        $this->form_validation->set_rules('EMAILSERVER', 'EMAILSERVER', 'trim');
        $this->form_validation->set_rules('SERVERPORT', 'SERVERPORT', 'trim');
        $this->form_validation->set_rules('EMAILSENDER', 'EMAILSENDER', 'trim');
        $this->form_validation->set_rules('EMAILCC', 'EMAILCC', 'trim');
        $this->form_validation->set_rules('EMAILBCC', 'EMAILBCC', 'trim');
        $this->form_validation->set_rules('AUTHUSER', 'AUTHUSER', 'trim');
        $this->form_validation->set_rules('AUTHPASSWORD', 'AUTHPASSWORD', 'trim');
        $this->form_validation->set_rules('COMPLAINTEMAIL', 'COMPLAINTEMAIL', 'trim');
        $this->form_validation->set_rules('COMPLAINTUSERNAME', 'COMPLAINTUSERNAME', 'trim');
        $this->form_validation->set_rules('COMPLAINTPASSWORD', 'COMPLAINTPASSWORD', 'trim');
        $this->form_validation->set_rules('COMPLAINTACTIVE', 'COMPLAINTACTIVE', 'trim');
        $this->form_validation->set_rules('ENQUIRYEMAIL', 'ENQUIRYEMAIL', 'trim');
        $this->form_validation->set_rules('ENQUIRYUSERNAME', 'ENQUIRYUSERNAME', 'trim');
        $this->form_validation->set_rules('ENQUIRYPASSWORD', 'ENQUIRYPASSWORD', 'trim');
        $this->form_validation->set_rules('ENQUIRYACTIVE', 'ENQUIRYACTIVE', 'trim');
        
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Admin'){
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
		}
		else
        {
			//validation succeed
			$COMPLAINTEMAIL = $this->input->post('COMPLAINTEMAIL');
			if($COMPLAINTEMAIL == ''){
				$COMPLAINTEMAIL = NULL;
			}
			
			$COMPLAINTUSERNAME = $this->input->post('COMPLAINTUSERNAME');
			if($COMPLAINTUSERNAME == ''){
				$COMPLAINTUSERNAME = NULL;
			}
			
			$COMPLAINTPASSWORD = $this->input->post('COMPLAINTPASSWORD');
			if($COMPLAINTPASSWORD == ''){
				$COMPLAINTPASSWORD = NULL;
			}
			
			$ENQUIRYEMAIL = $this->input->post('ENQUIRYEMAIL');
			if($ENQUIRYEMAIL == ''){
				$ENQUIRYEMAIL = NULL;
			}
			
			$ENQUIRYUSERNAME = $this->input->post('ENQUIRYUSERNAME');
			if($ENQUIRYUSERNAME == ''){
				$ENQUIRYUSERNAME = NULL;
			}
			
			$ENQUIRYPASSWORD = $this->input->post('ENQUIRYPASSWORD');
			if($ENQUIRYPASSWORD == ''){
				$ENQUIRYPASSWORD = NULL;
			}
			
            $data = array(
				'EMAILSERVER' => $this->input->post('EMAILSERVER'),
				'SERVERPORT' => $this->input->post('SERVERPORT'),
				'EMAILSENDER' => $this->input->post('EMAILSENDER'),
				'EMAILCC' => $this->input->post('EMAILCC'),
				'EMAILBCC' => $this->input->post('EMAILBCC'),
				'AUTHUSER' => $this->input->post('AUTHUSER'),
				'AUTHPASSWORD' => $this->input->post('AUTHPASSWORD'),
				'COMPLAINTEMAIL' => $COMPLAINTEMAIL,
				'COMPLAINTUSERNAME' => $COMPLAINTUSERNAME,
				'COMPLAINTPASSWORD' => $COMPLAINTPASSWORD,
				'COMPLAINTACTIVE' => $this->input->post('COMPLAINTACTIVE'),
				'ENQUIRYEMAIL' => $ENQUIRYEMAIL,
				'ENQUIRYUSERNAME' => $ENQUIRYUSERNAME,
				'ENQUIRYPASSWORD' => $ENQUIRYPASSWORD,
				'ENQUIRYACTIVE' => $this->input->post('ENQUIRYACTIVE'),
				'CONDOSEQ' => $CondoSeq,
            );

			$this->db->where('CondoSeq', $CondoSeq);
			$this->db->from('WebCtrl');
			$result = $this->db->count_all_results();

			if($result == 0) //not exist
			{
				//insert record
				$this->db->insert('WebCtrl', $data);
				//display success message
				$this->session->set_flashdata('email', '<script language=javascript>alert("Added");</script>');
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
			else //exist
			{
				//update record
				$this->db->where('CondoSeq', $CondoSeq);
				$this->db->update('WebCtrl', $data);
				//display success message
				$this->session->set_flashdata('email', '<script language=javascript>alert("Updated");</script>');
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
		}
	}
	
	public function SendPwSetup($CondoSeq)
	{
		//set validation rules
        $this->form_validation->set_rules('SENDPASSWORDTEXT', 'SENDPASSWORDTEXT', 'trim');
        
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Admin'){
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
		}
		else
        {
			//validation succeed
            $data = array(
				'SENDPASSWORDTEXT' => $this->input->post('SENDPASSWORDTEXT'),
				'CONDOSEQ' => $CondoSeq,
            );

			$this->db->where('CondoSeq', $CondoSeq);
			$this->db->from('WebCtrl');
			$result = $this->db->count_all_results();
			
			if($result == 0) //not exist
			{
				//insert record
				$this->db->insert('WebCtrl', $data);
				//display success message
				$this->session->set_flashdata('sendpw', '<script language=javascript>alert("Added");</script>');
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
			else //exist
			{
				//update record
				$this->db->where('CondoSeq', $CondoSeq);
				$this->db->update('WebCtrl', $data);
				//display success message
				$this->session->set_flashdata('sendpw', '<script language=javascript>alert("Updated");</script>');
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
		}
	}
	
	public function Jompay($CondoSeq)
	{
		//set validation rules
        $this->form_validation->set_rules('JompayChck', ' Jom Pay', 'trim');
        
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Admin'){
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'JOMPAY' => $this->input->post('JompayChck'),
            );

			$this->cportal->from('Company');
			$result = $this->cportal->count_all_results();
			
			if($result == 0) //not exist
			{
				//insert record
				$this->cportal->insert('Company', $data);
				//display success message
				$this->session->set_flashdata('jompay', '<script language=javascript>alert("Added");</script>');
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
			else //exist
			{
				//update record
				$this->cportal->update('Company', $data);
				//display success message
				$this->session->set_flashdata('jompay', '<script language=javascript>alert("Updated");</script>');
				redirect('index.php/Common/Setup/ServerSetup/'.$CondoSeq);
			}
		}
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class blockusers extends CI_Controller {
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
		$this->load->library('PHPRequests');
		
		//load the model
		$this->load->model('booking_model');
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
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['blockList'] = $this->booking_model->get_blockUser_list();
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			//load the view
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Facilities/BlockUsers',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
	public function Blockusers()
	{
		//set validation rules
        $this->form_validation->set_rules('EnableBlockUser', 'EnableBlockUser', 'trim');
        $this->form_validation->set_rules('BlockMethod', 'BlockMethod', 'trim');
        $this->form_validation->set_rules('OverDueAmount', 'OverDueAmount', 'trim');
        $this->form_validation->set_rules('OverDueDays', 'OverDueDays', 'trim');
        // $this->form_validation->set_rules('DefaulterMsg', 'DefaulterMsg', 'trim');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Admin'){
				redirect('index.php/Common/Setup/ServerSetup/'.$_SESSION['condoseq']);
			}
		}
		else
        {
			//validation succeed
			$enable = $this->input->post('EnableBlockUser');
			if($enable == 'on'){
				$enable = 'Y';
			}
			else{
				$enable = 'N';
			}
			
			$block = $this->input->post('BlockMethod');
			if($block == 'Amount'){
				$block = '1';
			}
			else if($block == 'Day'){
				$block = '2';
			}
			else if($block == 'AmtnDay'){
				$block = '3';
			}
			else if($block == 'AmtoDay'){
				$block = '4';
			}
			
			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();

			$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'Enabled' => $enable, 'BlockMethod' => $block, 'OverdueAmount' => $this->input->post('OverDueAmount'), 'OverdueDays' => $this->input->post('OverDueDays'));
			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/BlackListSet';
			$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
			$response = Requests::post($url, $headers, json_encode($jsonData));
			$body = json_decode($response->body, true);

			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/BlockUsers/Index');
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
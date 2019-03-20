<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forgetPassword extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->helper('email');
		$this->load->library('form_validation');
		$this->load->library('PHPRequests');
		
		//load the model
		$this->load->model('forgetpassword_model');
		$this->load->model('header_model');
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	public function Index()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		$this->load->view('Default/ForgetPassword',$data);
	}
	
	public function ForgetPassword()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$company = $this->header_model->get_Company();
		$forgetPassword = $this->forgetpassword_model->get_forget_service();

		if(isset($forgetPassword)){
			foreach ($forgetPassword as $file) {
				$email = $file['email'];
				$loginID = $file['loginID'];
			}
		}
		else{
			$email = "";
			$loginID = "";
		}
		
		$data['loginID'] = $loginID;
		
		$jsonData = '{"Email":"'.$email.'","LoginID":"'.$loginID.'"}';
				
		//display message
		$this->session->set_flashdata('msg', '<script language=javascript>alert("New password sent. Kindly check your email for the new password.");</script>');
		redirect(base_url());
		
	}
}
?>
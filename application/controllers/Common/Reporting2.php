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
	
	public function FeedbackS()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		$this->load->view('../Reporting/feedbackSumm');
	}
	
	public function FeedbackD()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		
		//load the view
		$this->load->view('../Reporting/feedbackDetails');
	}
}
?>
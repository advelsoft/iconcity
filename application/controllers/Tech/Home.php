<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller

{
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
		$this->load->model('index_model');
		
		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url());
        }
	}

	public function Index()
	{
		//call the model  
		$data['feedback'] = $this->index_model->get_feedback();    
		$data['feedbackList'] = $this->index_model->get_feedback_details();
		$data['company'] = $this->index_model->get_Company();  
		
		//load the view
		$data_view = array(
			"tab1" => $this->load->view('Tech/IndexFeedback', $data, TRUE)
		);
		
		$this->load->view('Tech/Index',$data_view);
	}
}
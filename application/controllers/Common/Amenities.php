<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class amenities extends CI_Controller {
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
		$this->load->model('amenities_model');
		$this->load->model('header_model');
		
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
        $data['amenities'] = $this->amenities_model->get_amenities_list();
		
		//set validation rules
        $this->form_validation->set_rules('Title', 'Title', 'trim|required');
        $this->form_validation->set_rules('Summary', 'Summary', 'required');
        $this->form_validation->set_rules('Description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Setup/Amenities/Index',$data);
			}
        }
        else
        {
			//validation succeed
			$this->cportal->from('Amenities');
			$query = $this->cportal->get();
			$result = $query->result();

			if(count($result) == 0) //not exist
			{
				$data = array(
					'Title' => $this->input->post('Title'),
					'Summary' => $this->input->post('Summary'),
					'Description' => $this->input->post('Description'),
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
				);
			
				//insert record
				$this->cportal->insert('Amenities', $data);
				
				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
				redirect('index.php/Common/Amenities/Index');
			}
			else
			{
				$data = array(
					'Title' => $this->input->post('Title'),
					'Summary' => $this->input->post('Summary'),
					'Description' => $this->input->post('Description'),
					'ModifiedBy' => $_SESSION['userid'],
					'ModifiedDate' => date('Y-m-d H:i:s'),
				);
				
				//update record
				$this->cportal->where('AmenitiesId', $result[0]->AmenitiesId);
				$this->cportal->update('Amenities', $data);
				
				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
				redirect('index.php/Common/Amenities/Index');
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
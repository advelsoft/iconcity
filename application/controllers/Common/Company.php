<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class company extends CI_Controller {
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
		$this->load->model('company_model');
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
        $data['company'] = $this->company_model->get_company_list();
		
		//set validation rules
        $this->form_validation->set_rules('Name', 'Name', 'trim|required');
        $this->form_validation->set_rules('Contact', 'Contact', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Setup/Company/Index',$data);
			}
        }
        else
        {
			//validation succeed
			$this->cportal->from('Company');
			$query = $this->cportal->get();
			$result = $query->result();

			if(count($result) == 0) //not exist
			{
				$data = array(
					'COMPANYNAME' => $this->input->post('Name'),
					'CONTACT' => $this->input->post('Contact'),
					'CREATEDBY' => $_SESSION['userid'],
					'CREATEDDATE' => date('Y-m-d H:i:s'),
				);
			
				//insert record
				$this->cportal->insert('Company', $data);
				
				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
				redirect('index.php/Common/Company/Index');
			}
			else
			{
				$data = array(
					'COMPANYNAME' => $this->input->post('Name'),
					'CONTACT' => $this->input->post('Contact'),
					'MODIFIEDBY' => $_SESSION['userid'],
					'MODIFIEDDATE' => date('Y-m-d H:i:s'),
				);
			
				//update record
				$this->cportal->where('COMPANYID', $result[0]->CompanyID);
				$this->cportal->update('Company', $data);
				
				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
				redirect('index.php/Common/Company/Index');
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
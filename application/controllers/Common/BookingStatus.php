<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bookingStatus extends CI_Controller {
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
		
		//load the model
		$this->load->model('booking_model');
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
		$data['bookingStatusList'] = $this->booking_model->get_bookingStatus_list();
		$data['btStatus'] = $this->booking_model->get_BTStatus();
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Facilities/BookingStatus',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['bookingStatusList'] = $this->booking_model->get_bookingStatus_list();
		$data['btStatus'] = $this->booking_model->get_BTStatus();
		
		//set validation rules
        $this->form_validation->set_rules('Status', 'Status', 'trim|required');
        $this->form_validation->set_rules('Active', 'Active');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Facilities/BookingStatus',$data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
            $data = array(
                'Status' => $this->input->post('Status'),
                'Active' => $this->input->post('Active'),
                'CreatedBy' => $_SESSION['userid'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );
			
            //insert record
            $this->cportal->insert('BookingTypeStatus', $data);

            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
            redirect('index.php/Common/BookingStatus/Index');
        }
    }
	
	public function Update($BTStatusID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['bookingStatusList'] = $this->booking_model->get_bookingStatus_list();
		$data['btStatus'] = $this->booking_model->get_BTStatus();
		
		//set validation rules
        $this->form_validation->set_rules('Status', 'Status', 'trim|required');
        $this->form_validation->set_rules('Active', 'Active');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Facilities/BookingStatus',$data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
            $data = array(
                'Status' => $this->input->post('Status'),
                'Active' => $this->input->post('Active'),
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );
			
			//update BookingType record
            $this->cportal->where('BTStatusID', $BTStatusID);
            $this->cportal->update('BookingTypeStatus', $data);

            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
            redirect('index.php/Common/BookingStatus/Index');
        }
	}
	
	public function Delete($BTStatusID)
	{
		//delete User record
        $this->cportal->where('BTStatusID', $BTStatusID);
        $this->cportal->delete('BookingTypeStatus');
        redirect('index.php/Common/BookingStatus/Index');
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
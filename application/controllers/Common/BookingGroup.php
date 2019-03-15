<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bookingGroup extends CI_Controller {
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
		$data['bookingGroupList'] = $this->booking_model->get_bookingGroup_list();
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Facilities/BookingGroup',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['bookingGroupList'] = $this->booking_model->get_bookingGroup_list();
		
		//set validation rules
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('PerBookingDay', 'Per Booking Day', 'required');
        $this->form_validation->set_rules('AdvanceBookingDays', 'Advance Booking Days', 'required');
        $this->form_validation->set_rules('MaxBookPerSection', 'Max Book Per Section', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Facilities/BookingGroup',$data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
			//auto increment for groupcode (same as groupid)
			$sql = "SELECT MAX(CAST(GROUPCODE as INT)) AS maxGroupCode FROM BookingTypeGroup";
			$query = $this->cportal->query($sql);
			$result = $query->result();
			$groupCode = $result[0]->maxGroupCode;
			$groupCode++;
			
            $data = array(
                'GROUPCODE' => $groupCode,
                'DESCRIPTION' => $this->input->post('Description'),
                'PERBOOKINGDAY' => $this->input->post('PerBookingDay'),
                'ADVANCEBOOKINGDAYS' => $this->input->post('AdvanceBookingDays'),
                'MAXBOOKPERSECTION' => $this->input->post('MaxBookPerSection'),
                'CREATEDBY' => $_SESSION['userid'],
                'CREATEDDATE' => date('Y-m-d H:i:s'),
            );
			
            //insert record
            $this->cportal->insert('BookingTypeGroup', $data);

            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
            redirect('index.php/Common/BookingGroup/Index');
        }
    }
	
	public function Update($GROUPID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['bookingGroupList'] = $this->booking_model->get_bookingGroup_list();
		
		//set validation rules
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('PerBookingDay', 'Per Booking Day', 'required');
        $this->form_validation->set_rules('AdvanceBookingDays', 'Advance Booking Days', 'required');
        $this->form_validation->set_rules('MaxBookPerSection', 'Max Book Per Section', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Facilities/BookingGroup',$data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
            $data = array(
                'DESCRIPTION' => $this->input->post('Description'),
                'PERBOOKINGDAY' => $this->input->post('PerBookingDay'),
                'ADVANCEBOOKINGDAYS' => $this->input->post('AdvanceBookingDays'),
                'MAXBOOKPERSECTION' => $this->input->post('MaxBookPerSection'),
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );
			
			//update BookingType record
            $this->cportal->where('GROUPID', $GROUPID);
            $this->cportal->update('BookingTypeGroup', $data);

            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
            redirect('index.php/Common/BookingGroup/Index');
        }
	}
	
	public function Delete($GROUPID)
	{
		//delete User record
        $this->cportal->where('GROUPID', $GROUPID);
        $this->cportal->delete('BookingTypeGroup');
        redirect('index.php/Common/BookingGroup/Index');
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
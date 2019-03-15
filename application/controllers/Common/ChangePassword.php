<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class changePassword extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	
	public function Index()
	{
		//load the view
		$this->load->view('Mgmt/header');
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/Setup/ChangePw');
		$this->load->view('Mgmt/footer');
	}
	
	public function Changepw()
	{
		//set validation rules
        $this->form_validation->set_rules('OldPw', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('NewPw', 'New Password', 'trim|required');
        $this->form_validation->set_rules('ConfirmPw', 'Confirm New Password', 'trim|required|matches[NewPw]');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('Mgmt/header');
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/ChangePw');
			$this->load->view('Mgmt/footer');
		}
		else
        {
			//validation succeed
            $log = array(
				'LoginID' => $_SESSION['username'],
				'OldPassword' => $this->input->post('OldPw'),
				'NewPassword' => $this->input->post('NewPw'),
				'CreatedDate' => date('Y-m-d H:i:s'),
            );

            //insert record
            $this->db->insert('ForgetPasswordLog', $log);
			
			$users = array('LOGINPASSWORD' => $this->input->post('NewPw'));
			
			//update record
            $this->db->where('LOGINID', $_SESSION['username']);
            $this->db->where('LOGINPASSWORD', $this->input->post('OldPw'));
            $this->db->update('Users', $users);

			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Your password has successfully changed.");</script>');
			redirect('index.php/Common/ChangePassword/Index');
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

	function accept_terms()
	{
        if ($this->input->post('accept_terms_checkbox'))
		{
			return TRUE;
		}
		else
		{
			$error = 'Please read and accept our terms and conditions.';
			$this->form_validation->set_message('accept_terms', $error);
			return FALSE;
		}
	}
}
?>
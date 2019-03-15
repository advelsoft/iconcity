<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profileSet extends CI_Controller {
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
		$this->load->model('profileset_model');
		$this->load->model('header_model');
		$this->cportal = $this->load->database('cportal',TRUE);
		
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
        $data['profileSet'] = $this->profileset_model->get_change_list();
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/ProfileSet',$data);
			$this->load->view('Mgmt/footer');
		}
		else if($_SESSION['role'] == 'Tech'){
			$this->load->view('Tech/header',$data);
			$this->load->view('Tech/nav');
			$this->load->view('Tech/ProfileSet',$data);
			$this->load->view('Tech/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/ProfileSet',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function ProfileSet()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $data['profileSet'] = $this->profileset_model->get_change_list();

		//set validation rules
		$this->form_validation->set_rules('OldUser', 'Old Username', 'trim');
        $this->form_validation->set_rules('NewUser', 'New Username', 'trim');
        $this->form_validation->set_rules('OldPw', 'Old Password', 'trim');
        $this->form_validation->set_rules('NewPw', 'New Password', 'trim|required');
        $this->form_validation->set_rules('ConfirmPw', 'Confirm New Password', 'trim|required|matches[NewPw]');

		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/ProfileSet',$data);
				$this->load->view('Mgmt/footer');
			}
			else if($_SESSION['role'] == 'Tech'){
				$this->load->view('Tech/header',$data);
				$this->load->view('Tech/nav');
				$this->load->view('Tech/ProfileSet',$data);
				$this->load->view('Tech/footer');
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/ProfileSet',$data);
				$this->load->view('User/footer');
			}
		}
		else
        {
			//validation succeed
			if($_SESSION['role'] == 'Mgmt' || $_SESSION['role'] == 'Tech'){
				$log = array(
					'OldLoginID' => $this->input->post('OldUser'),
					'NewLoginID' => $this->input->post('NewUser'),
					'OldPassword' => $this->input->post('OldPw'),
					'NewPassword' => $this->input->post('NewPw'),
					'CreatedDate' => date('Y-m-d H:i:s'),
				);

				//insert record
				$this->db->insert('ChangeProfileLog', $log);

				if($this->input->post('NewUser') != ''){
					$users = array('LOGINID' => $this->input->post('NewUser'),
								   'LOGINPASSWORD' => $this->input->post('NewPw'));
								   
					//update record
					$this->db->where('LOGINID', $this->input->post('OldUser'));
					$this->db->where('LOGINPASSWORD', $this->input->post('OldPw'));
					$this->db->update('Users', $users);
				}
				else{
					$users = array('LOGINPASSWORD' => $this->input->post('NewPw'));
					
					//update record
					$this->db->where('LOGINID', $this->input->post('OldUser'));
					$this->db->where('LOGINPASSWORD', $this->input->post('OldPw'));
					$this->db->update('Users', $users);
				}
			}
			else{
				$log = array(
					'OldLoginID' => $this->input->post('OldUser'),
					'NewLoginID' => $this->input->post('NewUser'),
					'OldPassword' => $this->input->post('OldPw'),
					'NewPassword' => $this->input->post('NewPw'),
					'CreatedDate' => date('Y-m-d H:i:s'),
				);

				//insert record
				$this->cportal->insert('ChangeProfileLog', $log);

				if($this->input->post('NewUser') != ''){
					$users = array('LOGINID' => $this->input->post('NewUser'),
								   'LOGINPASSWORD' => $this->input->post('NewPw'));
								   
					//update record
					$this->cportal->where('LOGINID', $this->input->post('OldUser'));
					$this->cportal->where('LOGINPASSWORD', $this->input->post('OldPw'));
					$this->cportal->update('Users', $users);
				}
				else{
					$users = array('LOGINPASSWORD' => $this->input->post('NewPw'));
					
					//update record
					$this->cportal->where('LOGINID', $this->input->post('OldUser'));
					$this->cportal->where('LOGINPASSWORD', $this->input->post('OldPw'));
					$this->cportal->update('Users', $users);
				}
			}

			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Please re-login with your new username and password.");</script>');
			redirect(base_url());
		}
	}
}
?>
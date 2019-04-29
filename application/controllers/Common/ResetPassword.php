<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class resetPassword extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->helper('email');
		$this->load->library("pagination");
		$this->load->library('form_validation');
		$this->load->library('PHPRequests');
		
		//load the model
		$this->load->model('resetpassword_model');
		$this->load->model('header_model');
		$this->load->model('login_model');
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}

	public function Search($page=1)
	{
		$data['company'] = $this->header_model->get_Company();
		$data['unitNo'] = $this->login_model->get_AllUnit();
		$propertyNo = $this->input->post('propertyNo');
		$fbList = $this->resetpassword_model->get_user($propertyNo);
		$data['usersList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($fbList) > 0) {
            $paginatedFiles = array_slice($fbList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['usersList'][] = array('userID'=>$file['userID'],
													 'loginID'=>$file['loginID'],
													 'propertyNo'=>$file['propertyNo'],
													 'ownerName'=>$file['ownerName'],
													 'email'=>$file['email']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/ResetPassword/Index";
        $config['total_rows'] = count($fbList);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
		//load the view
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/footer');
		$this->load->view('Mgmt/Setup/ResetPassword/Index',$data);
	}

	public function Index($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['unitNo'] = $this->login_model->get_AllUnit();
        $fbList = $this->resetpassword_model->get_users_list();
        $data['usersList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($fbList) > 0) {
            $paginatedFiles = array_slice($fbList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['usersList'][] = array('userID'=>$file['userID'],
													 'loginID'=>$file['loginID'],
													 'propertyNo'=>$file['propertyNo'],
													 'ownerName'=>$file['ownerName'],
													 'email'=>$file['email']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/ResetPassword/Index";
        $config['total_rows'] = count($fbList);
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">'; 
        $config['full_tag_close'] = '</ul>'; 
        $config['num_tag_open'] = '<li>'; 
        $config['num_tag_close'] = '</li>'; 
        $config['cur_tag_open'] = '<li class="active"><span>'; 
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>'; 
        $config['prev_tag_open'] = '<li>'; 
        $config['prev_tag_close'] = '</li>'; 
        $config['next_tag_open'] = '<li>'; 
        $config['next_tag_close'] = '</li>'; 
        $config['first_link'] = '&laquo;'; 
        $config['prev_link'] = '&lsaquo;'; 
        $config['last_link'] = '&raquo;'; 
        $config['next_link'] = '&rsaquo;'; 
        $config['first_tag_open'] = '<li>'; 
        $config['first_tag_close'] = '</li>'; 
        $config['last_tag_open'] = '<li>'; 
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
		
		//load the view
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/footer');
		$this->load->view('Mgmt/Setup/ResetPassword/Index',$data);
	}
	
	public function ResetPassword($UID)
	{
		//call the model
		$data['userID'] = $UID;
		$data['company'] = $this->header_model->get_Company();
		$company = $this->header_model->get_Company();
		$resetPassword = $this->resetpassword_model->get_reset_service($UID);

		if(isset($resetPassword)){
			foreach ($resetPassword as $file) {
				$UID = $file['userID'];
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
		$this->session->set_flashdata('msg', '<script language=javascript>alert("New password sent. Kindly check email for the new password.");</script>');
		redirect('index.php/Common/ResetPassword/Index');
	}
}
?>
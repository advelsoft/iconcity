<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		$this->jompay = $this->load->database('jompay',TRUE);
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');		
		
		//load the model
		$this->load->model('user_model');
		$this->load->model('header_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
            redirect(base_url().'index.php/Common/Login/Login');
        }
	}
	
	public function Index($page=1)
	{		
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $userList = $this->user_model->get_user_list();
        $data['userList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($userList) > 0) {
            $paginatedFiles = array_slice($userList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['userList'][] = array('userID'=>$file['userID'],
											'loginID'=>$file['loginID'],
										    'name'=>$file['name'],
										    'email'=>$file['email'],
										    'role'=>$file['role'],
										    'condoName'=>$file['condoName'],
										    'createdBy'=>$file['createdBy'],
										    'createdDate'=>$file['createdDate'],
										    'modifiedBy'=>$file['modifiedBy'],
										    'modifiedDate'=>$file['modifiedDate']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Users/Index";
        $config['total_rows'] = count($userList);
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
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav');
		$this->load->view('Admin/footer');
		$this->load->view('Admin/Setup/Users/Index',$data);
	}
	
	public function Create()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
        $data['userRole'] = $this->user_model->get_UserRole();
        $data['condo'] = $this->user_model->get_Condo();
		
        //set validation rules
        $this->form_validation->set_rules('LoginID', 'LoginID', 'trim|required');
        $this->form_validation->set_rules('Name', 'Name', 'trim|required');
        $this->form_validation->set_rules('Email', 'Email', 'trim|required');
        $this->form_validation->set_rules('LoginPassword', 'LoginPassword', 'trim|required');
        $this->form_validation->set_rules('Role', 'Role', 'callback_combo_check|required');
        $this->form_validation->set_rules('CondoSeq', 'CondoSeq', 'callback_combo_check|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fails
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Users/Create',$data);
			$this->load->view('Admin/footer');
        }
        else
        {
			//validation succeeds
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $this->input->post('CondoSeq'));
			$query = $this->jompay->get();
			$result = $query->result();
			$condoName = $result[0]->DESCRIPTION;
			
            $data = array(
                'LoginID' => $this->input->post('LoginID'),
                'Name' => $this->input->post('Name'),
                'Email' => $this->input->post('Email'),
                'Phone' => $this->input->post('Phone'),
                'Role' => $this->input->post('Role'),
                'LoginPassword' => $this->input->post('LoginPassword'),
                'CondoSeq' => $this->input->post('CondoSeq'),
                'CondoName' => $condoName,
                'CreatedBy' => $_SESSION['userid'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );
			
            //insert the form data into database
            $this->jompay->insert('Users', $data);
			
            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');			
			redirect('index.php/Common/Users/Index');
        }
	}
	
	public function Detail($UserID)
	{		
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['userRecord'] = $this->user_model->get_user_record($UserID);
		
		//load the view
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav');
		$this->load->view('Admin/Setup/Users/Detail',$data);
		$this->load->view('Admin/footer');
	}
	
	public function Update($UserID)
	{
		//call the model function to get the data
		$data['UserID'] = $UserID;
		$data['company'] = $this->header_model->get_Company();
		$data['userRole'] = $this->user_model->get_UserRole();
		$data['condo'] = $this->user_model->get_Condo();
		$data['userRecord'] = $this->user_model->get_user_record($UserID);

        //set validation rules
		$this->form_validation->set_rules('LoginID', 'LoginID', 'trim|required');
        $this->form_validation->set_rules('Name', 'Name', 'trim|required');
        $this->form_validation->set_rules('Email', 'Email', 'trim|required');
        $this->form_validation->set_rules('LoginPassword', 'LoginPassword', 'trim|required');
        $this->form_validation->set_rules('Role', 'Role', 'callback_combo_check|required');
        $this->form_validation->set_rules('CondoSeq', 'CondoSeq', 'callback_combo_check|required');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fails
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Users/Update',$data);
			$this->load->view('Admin/footer');
        }
        else
        {
            //validation succeeds
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $this->input->post('CondoSeq'));
			$query = $this->jompay->get();
			$result = $query->result();
			$condoName = $result[0]->DESCRIPTION;
			
             $data = array(
                'LoginID' => $this->input->post('LoginID'),
                'Name' => $this->input->post('Name'),
                'Email' => $this->input->post('Email'),
                'Phone' => $this->input->post('Phone'),
                'Role' => $this->input->post('Role'),
                'LoginPassword' => $this->input->post('LoginPassword'),
                'CondoSeq' => $this->input->post('CondoSeq'),
                'CondoName' => $condoName,
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

            //update FacilityBooking record
            $this->jompay->where('UserID', $UserID);
            $this->jompay->update('Users', $data);

            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
            redirect('index.php/Common/Users/Index');
        }
	}
	
	public function Delete($UserID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['userRecord'] = $this->user_model->get_user_record($UserID);
		
		//load the view		
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav');
		$this->load->view('Admin/Setup/Users/Delete',$data);
		$this->load->view('Admin/footer');
	}
	
	//delete User record from db
    function delete_record($UserID)
    {
        //delete User record
        $this->jompay->where('UserID', $UserID);
        $this->jompay->delete('Users');
        redirect('index.php/Common/Users/index');
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
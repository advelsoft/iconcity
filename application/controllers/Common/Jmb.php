<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jmb extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		$this->jompay = $this->load->database('jompay',TRUE);
		$this->cportal = $this->load->database('cportal',TRUE);
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');		
		
		//load the model
		$this->load->model('jmb_model');
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
        $jmbList = $this->jmb_model->get_jmb_list();
        $data['jmbList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($jmbList) > 0) {
            $paginatedFiles = array_slice($jmbList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['jmbList'][] = array('UID'=>$file['UID'],
										   'userID'=>$file['userID'],
										   'propertyNo'=>$file['propertyNo'],
										   'ownerName'=>$file['ownerName'],
										   'createdBy'=>$file['createdBy'],
										   'createdDate'=>$file['createdDate'],
										   'modifiedBy'=>$file['modifiedBy'],
										   'modifiedDate'=>$file['modifiedDate']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Jmb/Index";
        $config['total_rows'] = count($jmbList);
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
		$this->load->view('Mgmt/Setup/Jmb/Index',$data);
	}
	
	public function Create()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
        $data['usersList'] = $this->jmb_model->get_UsersList();
		
        //set validation rules
        $this->form_validation->set_rules('PropertyNo', 'PropertyNo', 'callback_combo_check');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fails
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Jmb/Create',$data);
			$this->load->view('Mgmt/footer');
        }
        else
        {
			//validation succeeds
			$propNo = $this->input->post('PropertyNo');

			for($i = 0; $i < count($propNo); $i++){
				//get user id
				$this->cportal->from('Users');
				$this->cportal->where('PropertyNo', $propNo[$i]);
				$query = $this->cportal->get();
				$result = $query->result();
				$userID = $result[0]->USERID;
				$ownerName = $result[0]->OWNERNAME;
				
				//check if exist
				$this->cportal->from('JMB');
				$this->cportal->where('PropertyNo', $propNo[$i]);
				$query1 = $this->cportal->get();
				$result1 = $query1->result();
				
				if(count($result1) == 0){
					$data = array(
						'UserID' => $userID,
						'PropertyNo' => $propNo[$i],
						'OwnerName' => $ownerName,
						'CreatedBy' => $_SESSION['userid'],
						'CreatedDate' => date('Y-m-d H:i:s'),
					);

					//insert records
					$this->cportal->insert('JMB', $data);
				}
			}
			
            //display message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');			
			redirect('index.php/Common/Jmb/Index');
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
            $this->db->where('UserID', $UserID);
            $this->db->update('Users', $data);

            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
            redirect('index.php/Common/Users/Index');
        }
	}
	
	public function Delete($UserID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['userRecord'] = $this->jmb_model->get_user_record($UserID);
		
		//load the view		
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav');
		$this->load->view('Mgmt/Setup/Jmb/Delete',$data);
		$this->load->view('Mgmt/footer');
	}
	
	//delete User record from db
    function delete_record($UserID)
    {
        //delete User record
        $this->cportal->where('UserID', $UserID);
        $this->cportal->delete('JMB');
        redirect('index.php/Common/Jmb/index');
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
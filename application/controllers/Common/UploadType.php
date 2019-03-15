<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class uploadType extends CI_Controller {
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
		$this->load->model('upload_model');
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
		$data['uploadTypeList'] = $this->upload_model->get_uploadType_list();
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Upload/UpdateType',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Upload/UpdateType',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['uploadTypeList'] = $this->upload_model->get_uploadType_list();
		
        //set validation rules
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Admin'){
				$this->load->view('Admin/header',$data);
				$this->load->view('Admin/nav');
				$this->load->view('Admin/Setup/Upload/UpdateType',$data);
				$this->load->view('Admin/footer');
			}
			else if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Upload/UpdateType',$data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
			$data = array(
				'Description' => $this->input->post('Description'),
				'CreatedBy' => $_SESSION['userid'],
				'CreatedDate' => date('Y-m-d H:i:s'),
			);
			
			//insert record
			$this->cportal->insert('UploadType', $data);

			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
			redirect('index.php/Common/UploadType/Index');
        }
    }
	
	public function Update($UploadTypeId)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['uploadTypeList'] = $this->upload_model->get_uploadType_list();
		
		//set validation rules
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Admin'){
				$this->load->view('Admin/header',$data);
				$this->load->view('Admin/nav');
				$this->load->view('Admin/Setup/Upload/UpdateType',$data);
				$this->load->view('Admin/footer');
			}
			else if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Upload/UpdateType',$data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
            $data = array(
                'Description' => $this->input->post('Description'),
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );
			
			//update record
            $this->cportal->where('UploadTypeId', $UploadTypeId);
            $this->cportal->update('UploadType', $data);

            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
            redirect('index.php/Common/UploadType/Index');
        }
	}
	
	public function Delete($UploadTypeId)
	{
		//delete record
        $this->cportal->where('UploadTypeId', $UploadTypeId);
        $this->cportal->delete('UploadType');
        redirect('index.php/Common/UploadType/Index');
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
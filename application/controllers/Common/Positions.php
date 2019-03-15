<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class positions extends CI_Controller {
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
		$this->load->model('department_model');
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
        $posList = $this->department_model->get_deptpos_list();
		$data['dept'] = $this->department_model->get_Department();
        $data['posList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($posList) > 0) {
            $paginatedFiles = array_slice($posList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['posList'][] = array('department'=>$file['department'],
										   'position'=>$file['position'],
										   'UID'=>$file['UID']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Positions/Index";
        $config['total_rows'] = count($posList);
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
		if($_SESSION['role'] == 'Mgmt'){
			//load the view
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Departments/Position',$data);
		}
	}
	
	public function Create()
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['posList'] = $this->department_model->get_deptpos_list();
		$data['dept'] = $this->department_model->get_Department();
		
		//set validation rules
        $this->form_validation->set_rules('Position', 'Position', 'trim|required');
        $this->form_validation->set_rules('Department', 'Department', 'callback_combo_check');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Departments/Position',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'Position' => $this->input->post('Position'),
				'Department' => $this->input->post('Department'),
				'CreatedBy' => $_SESSION['userid'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );

			//insert record
			$this->cportal->insert('DepartmentPosition', $data);
			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
			redirect('index.php/Common/Positions/Index');
		}
	}
	
	public function Update($UID)
	{
		//call the model function to get the data
		$data['company'] = $this->header_model->get_Company();
		$data['posList'] = $this->department_model->get_deptpos_list();
		$data['dept'] = $this->department_model->get_Department();
		
		//set validation rules
        $this->form_validation->set_rules('Position', 'Position', 'trim|required');
        $this->form_validation->set_rules('Department', 'Department', 'callback_combo_check');
		
		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				//load the view
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Departments/Position',$data);
				$this->load->view('Mgmt/footer');
			}
		}
		else
        {
			//validation succeed
			$data = array(
				'Position' => $this->input->post('Position'),
				'Department' => $this->input->post('Department'),
				'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

			//update record
			$this->cportal->where('UID', $UID);
			$this->cportal->update('DepartmentPosition', $data);
			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/Positions/Index');
		}
	}
	
	public function Delete($UID)
	{
		//delete User record
        $this->cportal->where('UID', $UID);
        $this->cportal->delete('DepartmentPosition');
        redirect('index.php/Common/Positions/Index');
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
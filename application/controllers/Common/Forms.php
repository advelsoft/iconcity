<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forms extends CI_Controller {
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
		$this->load->model('forms_model');
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
		$formList = $this->forms_model->get_form_list();
        $data['formList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($formList) > 0) {
            $paginatedFiles = array_slice($formList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['formList'][] = array('formID'=>$file['formID'],
										    'file'=>$file['file'],
										    'name'=>$file['name'],
										    'desc'=>$file['desc'],
										    'type'=>$file['type']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Forms/Index";
        $config['total_rows'] = count($formList);
        $config['per_page'] = 10;
        $config['num_links'] = 4;
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
		$this->load->view('Mgmt/nav',$data);
		$this->load->view('Mgmt/footer');
		$this->load->view('Mgmt/Setup/Forms/Index',$data);
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $data['formType'] = $this->forms_model->get_formType();
        $data['level'] = $this->forms_model->get_Level();
        $data['parentID'] = $this->forms_model->get_ParentID();

        //set validation rules
        $this->form_validation->set_rules('FormType', 'FormType', 'callback_combo_check|required');
        $this->form_validation->set_rules('FormName', 'FormName', 'required');
        $this->form_validation->set_rules('Level', 'Level', 'callback_combo_check|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav',$data);
			$this->load->view('Mgmt/Setup/Forms/Create',$data);
			$this->load->view('Mgmt/footer');
        }
        else
        {
			//validation succeed
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\forms';
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			//no file uploaded
			if($_FILES["FormFile"]["error"] == 4){ 
				$data = array(
					'FormType' => $this->input->post('FormType'),
					'FormName' => $this->input->post('FormName'),
					'FormFile' => '#',
					'Level' => $this->input->post('Level'),
					'ParentID' => $this->input->post('ParentID'),
					'Sequence' => $this->input->post('Sequence'),
					'Mgmt' => $this->input->post('Mgmt'),
					'Owner' => $this->input->post('Owner'),
					'Tenant' => $this->input->post('Tenant'),
					'JMB' => $this->input->post('JMB'),
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
				);
				
				//insert record
				$this->cportal->insert('Form', $data);

				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
				redirect('index.php/Common/Forms/Index');
			}
			else{
				if(!empty($_FILES['FormFile'])){
					$fileName = str_replace(" ", "_", $_FILES['FormFile']['name']);
					$config['file_name'] = $fileName;
					$this->upload->initialize($config);
				}
				
				if (!$this->upload->do_upload('FormFile'))
				{
					// case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					redirect('index.php/Common/Forms/Create');
				}
				else
				{
					// case - success
					$upload_data = $this->upload->data();
					
					$this->thumb($upload_data,500,false);

					$data = array(
						'FormType' => $this->input->post('FormType'),
						'FormName' => $this->input->post('FormName'),
						'FormFile' => $config['file_name'],
						'Level' => $this->input->post('Level'),
						'ParentID' => $this->input->post('ParentID'),
						'Sequence' => $this->input->post('Sequence'),
						'Mgmt' => $this->input->post('Mgmt'),
						'Owner' => $this->input->post('Owner'),
						'Tenant' => $this->input->post('Tenant'),
						'JMB' => $this->input->post('JMB'),
						'CreatedBy' => $_SESSION['userid'],
						'CreatedDate' => date('Y-m-d H:i:s'),
					);

					//insert record
					$this->cportal->insert('Form', $data);

					//display success message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
					redirect('index.php/Common/Forms/Index');
				}
			}
        }
    }
	
	public function Update($FormID)
	{
		//call the model
		$data['formID'] = $FormID;
		$data['company'] = $this->header_model->get_Company();
        $data['formType'] = $this->forms_model->get_FormType();
        $data['formRecord'] = $this->forms_model->get_form_record($FormID);
		$data['level'] = $this->forms_model->get_Level();	
		$data['parentID'] = $this->forms_model->get_ParentID();

        //set validation rules
		$this->form_validation->set_rules('FormType', 'FormType', 'callback_combo_check|required');
        $this->form_validation->set_rules('FormName', 'FormName', 'required');
        $this->form_validation->set_rules('Level', 'Level', 'callback_combo_check|required');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav',$data);
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Forms/Update',$data);
        }
        else
        {
			//validation succeed
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\forms';
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			if($_FILES["FormFile"]["error"] == 4){
				$data = array(
					'FormType' => $this->input->post('FormType'),
					'FormName' => $this->input->post('FormName'),
					'Level' => $this->input->post('Level'),
					'ParentID' => $this->input->post('ParentID'),
					'Sequence' => $this->input->post('Sequence'),
					'Mgmt' => $this->input->post('Mgmt'),
					'Owner' => $this->input->post('Owner'),
					'Tenant' => $this->input->post('Tenant'),
					'JMB' => $this->input->post('JMB'),
					'ModifiedBy' => $_SESSION['userid'],
					'ModifiedDate' => date('Y-m-d H:i:s'),
				);

				//update record
				$this->cportal->where('FormID', $FormID);
				$this->cportal->update('Form', $data);
				
				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
				redirect('index.php/Common/Forms/Index');
			}
			else{
				if(!empty($_FILES['FormFile'])){
					$fileName = str_replace(" ", "_", $_FILES['FormFile']['name']);
					$config['file_name'] = $fileName;
					$this->upload->initialize($config);
				}
				else{
					$config['file_name'] = null;
				}
				
				if (!$this->upload->do_upload('FormFile'))
				{
					// case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					//echo '<pre>';
					//print_r($upload_error);
					redirect('index.php/Common/Forms/Upload/'.$FormID);
				}
				else
				{
					// case - success
					$upload_data = $this->upload->data();
					
					$this->thumb($upload_data,500,false);

					$data = array(
						'FormType' => $this->input->post('FormType'),
						'FormName' => $this->input->post('FormName'),
						'FormFile' => $config['file_name'],
						'Level' => $this->input->post('Level'),
						'ParentID' => $this->input->post('ParentID'),
						'Sequence' => $this->input->post('Sequence'),
						'Mgmt' => $this->input->post('Mgmt'),
						'Owner' => $this->input->post('Owner'),
						'Tenant' => $this->input->post('Tenant'),
						'JMB' => $this->input->post('JMB'),
						'ModifiedBy' => $_SESSION['userid'],
						'ModifiedDate' => date('Y-m-d H:i:s'),
					);

					//update record
					$this->cportal->where('FormID', $FormID);
					$this->cportal->update('Form', $data);

					//display success message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
					redirect('index.php/Common/Forms/Index');
				}
			}
        }
	}

	public function Delete($FormID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['formRecord'] = $this->forms_model->get_form_record($FormID);
		
		//load the view
		$this->load->view('Mgmt/header',$data);
		$this->load->view('Mgmt/nav',$data);
		$this->load->view('Mgmt/Setup/Forms/Delete',$data);
		$this->load->view('Mgmt/footer');
	}
	
    function delete_record($FormID)
    {
        //delete record
        $this->cportal->where('FormID', $FormID);
        $this->cportal->delete('Form');
        redirect('index.php/Common/Forms/Index');
    }
    
    function thumb($data,$thumb_size,$create_thumb)    
	{       
		//$config['image_library'] = 'gd2';    
		$config['source_image'] = $data['full_path'];      
		$config['create_thumb'] = $create_thumb;       
		$config['width'] = $thumb_size;
		$config['height'] = $thumb_size;     
		$this->load->library('image_lib', $config);    
		$this->image_lib->resize();
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
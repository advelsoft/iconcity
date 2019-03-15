<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class upload extends CI_Controller {
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
		$this->load->model('upload_model');
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
		$uploadList = $this->upload_model->get_upload_list();
        $data['uploadList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($uploadList) > 0) {
            $paginatedFiles = array_slice($uploadList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['uploadList'][] = array('uploadID'=>$file['uploadID'],
											  'file'=>$file['file'],
											  'type'=>$file['type'],
											  'createdBy'=>$file['createdBy'],
											  'createdDate'=>$file['createdDate']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Upload/Index";
        $config['total_rows'] = count($uploadList);
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
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/footer');
			$this->load->view('Admin/Setup/Upload/Index',$data);
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Upload/Index',$data);
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $data['uploadType'] = $this->upload_model->get_UploadType();

        //set validation rules
        $this->form_validation->set_rules('Type', 'Type', 'callback_combo_check');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Admin'){
				$this->load->view('Admin/header',$data);
				$this->load->view('Admin/nav');
				$this->load->view('Admin/Setup/Upload/Create',$data);
				$this->load->view('Admin/footer');
			}
			else if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Upload/Create',$data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
            //set preferences
			$config['upload_path'] = APPPATH.'uploads\files';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			//no file uploaded
			if($_FILES["File"]["error"] == 4){ 
				$this->session->set_flashdata('msg', '<script language=javascript>alert("No File!");</script>');
				redirect('index.php/Common/Upload/Create');
			}
			else{
				if(!empty($_FILES['File'])){
					$fileName = str_replace(" ", "_", $_FILES['File']['name']);
					$config['file_name'] = date("Ymdhis").'_'.$fileName;
					$this->upload->initialize($config);
				}
				
				if (!$this->upload->do_upload('File'))
				{
					// case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					$this->load->view('Admin/Setup/Upload/Create', $data);
				}
				else
				{
					// case - success
					$upload_data = $this->upload->data();
					
					$this->thumb($upload_data,500,false);

					$insert = array(
						'UploadFile' => $config['file_name'],
						'UploadType' => $this->input->post('Type'),
						'CreatedBy' => $_SESSION['userid'],
						'CreatedDate' => date('Y-m-d H:i:s'),
					);			
					//insert record
					$this->cportal->insert('Upload', $insert);

					//display success message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
					redirect('index.php/Common/Upload/Index');
				}
			}
        }
    }
	
	public function Detail($UploadID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['uploadRecord'] = $this->upload_model->get_upload_record($UploadID);
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Upload/Detail',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Upload/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
	public function Update($UploadID)
	{
		//call the model
		$data['uploadID'] = $UploadID;
		$data['company'] = $this->header_model->get_Company();
        $data['uploadType'] = $this->upload_model->get_UploadType();
        $data['uploadRecord'] = $this->upload_model->get_upload_record($UploadID);    

        //set validation rules
		$this->form_validation->set_rules('Type', 'Type', 'callback_combo_check');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			if($_SESSION['role'] == 'Admin'){
				$this->load->view('Admin/header',$data);
				$this->load->view('Admin/nav');
				$this->load->view('Admin/Setup/Upload/Update',$data);
				$this->load->view('Admin/footer');
			}
			else if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Upload/Update',$data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
            //set preferences
			$config['upload_path'] = APPPATH.'uploads\files';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			//no file uploaded
			if($_FILES["File"]["error"] == 4){ 
				$this->session->set_flashdata('msg', '<script language=javascript>alert("No File!");</script>');
				redirect('index.php/Common/Upload/Update/'.$UploadID);
			}
			else{
				if(!empty($_FILES['File'])){
					$fileName = str_replace(" ", "_", $_FILES['File']['name']);
					$config['file_name'] = date("Ymdhis").'_'.$fileName;
					$this->upload->initialize($config);
				}
				
				if (!$this->upload->do_upload('File'))
				{
					// case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					$this->load->view('Admin/Setup/Upload/Update', $data);
				}
				else
				{
					// case - success
					$upload_data = $this->upload->data();
					
					$this->thumb($upload_data,500,false);

					$update = array(
						'UploadFile' => $config['file_name'],
						'UploadType' => $this->input->post('Type'),
						'ModifiedBy' => $_SESSION['userid'],
						'ModifiedDate' => date('Y-m-d H:i:s'),
					);
					
					//update record
					$this->cportal->where('UploadID', $UploadID);
					$this->cportal->update('Upload', $update);

					//display success message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
					redirect('index.php/Common/Upload/Index');
				}
			}
        }
	}

	public function Delete($UploadID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['uploadRecord'] = $this->upload_model->get_upload_record($UploadID);
		
		//load the view
		if($_SESSION['role'] == 'Admin'){
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Upload/Delete',$data);
			$this->load->view('Admin/footer');
		}
		else if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Upload/Delete',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
    function delete_record($UploadID)
    {
        //delete record
        $this->cportal->where('UploadID', $UploadID);
        $this->cportal->delete('Upload');
        redirect('index.php/Common/Upload/Index');
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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class promoCategory extends CI_Controller {
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
		$this->load->model('promotion_model');
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
		$data['promoCatList'] = $this->promotion_model->get_promoCat_list();
		
		//load the view
		$this->load->view('Admin/header',$data);
		$this->load->view('Admin/nav');
		$this->load->view('Admin/Setup/Promotion/PromoCat',$data);
		$this->load->view('Admin/footer');
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['promoCatList'] = $this->promotion_model->get_promoCat_list();
		
        //set validation rules
        $this->form_validation->set_rules('Category', 'Category', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Promotion/PromoCat');
			$this->load->view('Admin/footer');
        }
        else
        {
			//validation succeed
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\promotion';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			//no file uploaded
			if($_FILES["Img"]["error"] == 4){ 
				$this->session->set_flashdata('msg', '<script language=javascript>alert("No File!");</script>');
				redirect('index.php/Common/PromoCategory/Index');
			}
			else{
				if(!empty($_FILES['Img'])){
					$fileName = str_replace(" ", "_", $_FILES['Img']['name']);
					$config['file_name'] = $fileName;
					$this->upload->initialize($config);
				}
				
				if (!$this->upload->do_upload('Img'))
				{
					// case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					$this->load->view('Admin/Setup/Promotion/PromoCat', $data);
				}
				else
				{
					// case - success
					$upload_data = $this->upload->data();
					
					$this->thumb($upload_data,500,false);

					$data = array(
						'Description' => $this->input->post('Category'),
						'PageLink' => $this->input->post('PageLink'),
						'Img' => $config['file_name'],
						'CreatedBy' => $_SESSION['userid'],
						'CreatedDate' => date('Y-m-d H:i:s'),
					);
					
					//insert record
					$this->db->insert('PromoCategory', $data);

					//display success message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
					redirect('index.php/Common/PromoCategory/Index');
				}
			}
        }
    }
	
	public function Update($PromoCatId)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['promoCatList'] = $this->promotion_model->get_promoCat_list();
		
		//set validation rules
        $this->form_validation->set_rules('Category', 'Category', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('Admin/header',$data);
			$this->load->view('Admin/nav');
			$this->load->view('Admin/Setup/Promotion/PromoCat',$data);
			$this->load->view('Admin/footer');
        }
        else
        {
			//validation succeed
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\promotion';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			//no file uploaded
			if($_FILES["Img"]["error"] == 4){ 
				$this->session->set_flashdata('msg', '<script language=javascript>alert("No File!");</script>');
				redirect('index.php/Common/Upload/Create');
			}
			else{
				if(!empty($_FILES['Img'])){
					$fileName = str_replace(" ", "_", $_FILES['Img']['name']);
					$config['file_name'] = $fileName;
					$this->upload->initialize($config);
				}
				
				if (!$this->upload->do_upload('Img'))
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

					$data = array(
						'Description' => $this->input->post('Category'),
						'PageLink' => $this->input->post('PageLink'),
						'Img' => $config['file_name'],
						'ModifiedBy' => $_SESSION['userid'],
						'ModifiedDate' => date('Y-m-d H:i:s'),
					);
					
					//update record
					$this->db->where('PromoCatId', $PromoCatId);
					$this->db->update('PromoCategory', $data);

					//display success message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
					redirect('index.php/Common/PromoCategory/Index');
				}
			}
        }
	}
	
	public function Delete($PromoCatId)
	{
		//delete record
        $this->db->where('PromoCatId', $PromoCatId);
        $this->db->delete('PromoCategory');
        redirect('index.php/Common/PromoCategory/Index');
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
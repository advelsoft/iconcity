<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bookingType extends CI_Controller {
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
		$this->load->model('booking_model');
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
        $bookTypeList = $this->booking_model->get_bookingType_list();
        $data['bookingTypeList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($bookTypeList) > 0) {
            $paginatedFiles = array_slice($bookTypeList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				$data['bookingTypeList'][] = array('description'=>$file['description'],
												   'groupCode'=>$file['groupCode'],
												   'status'=>$file['status'],
												   'maxBookHour'=>$file['maxBookHour'],
												   'createdBy'=>$file['createdBy'],
												   'createdDate'=>$file['createdDate'],
												   'modifiedBy'=>$file['modifiedBy'],
												   'modifiedDate'=>$file['modifiedDate'],
												   'bookingTypeID'=>$file['bookingTypeID']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/BookingType/Index";
        $config['total_rows'] = count($bookTypeList);
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
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Facilities/Index',$data);
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $data['maxBookHour'] = $this->booking_model->get_MaxBookHour();
        $data['btGroup'] = $this->booking_model->get_BTGroup();
        $data['btStatus'] = $this->booking_model->get_BTStatus();

        //set validation rules
        $this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('Status', 'Status', 'callback_combo_check');
        $this->form_validation->set_rules('MaxBookHour', 'Max Book Hour', 'callback_combo_check');
        $this->form_validation->set_rules('ViewOnly', 'Owner View Only');
        $this->form_validation->set_rules('AutoApproveBooking', 'Auto Approve Booking');
        $this->form_validation->set_rules('OtherFacility', 'Other Facility');
        $this->form_validation->set_rules('ManageBookAdmin', 'Manage Booking (Admin)');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Facilities/Create', $data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
			//validation succeed
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\facility';
			$config['allowed_types'] = 'png|jpg|jpeg';
			//$new_name = date("Ymdhis").'_'.$_FILES["ImgToShown"]['name'];
			$config['file_name'] = $_FILES["ImgToShown"]['name'];
			$config['overwrite'] = TRUE;
			
			//load upload class library
			$this->load->library('upload', $config);

			if ($_FILES AND $_FILES['ImgToShown']['name'])
			{
				if (!$this->upload->do_upload('ImgToShown'))
				{
					// case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('msg','<script language=javascript>alert("'.$upload_error['error'].'");</script>');
					$this->load->view('Mgmt/Setup/Facilities/Create', $data);
				}
				else
				{
					// case - success
					$upload_data = $this->upload->data();
					$fileName = $upload_data['file_name'];
	
					$data = array(
						'Description' => $this->input->post('Description'),
						'GroupID' => $this->input->post('GroupCode'),
						'GroupCode' => $this->input->post('GroupCode'),
						'BTStatusID' => $this->input->post('Status'),
						'MaxBookHour' => $this->input->post('MaxBookHour'),
						'ViewOnly' => $this->input->post('ViewOnly'),
						'AutoApproveBooking' => $this->input->post('AutoApproveBooking'),
						'OtherFacility' => $this->input->post('OtherFacility'),
						'ManageBookAdmin' => $this->input->post('ManageBookAdmin'),
						'Schedule' => $this->input->post('ResetBooking'),
						'SDuration' => $this->input->post('ResetHour'),
						'DailyBooking' => $this->input->post('DailyBooking'),
						'ImgToShown' => $fileName,
						'CreatedBy' => $_SESSION['userid'],
						'CreatedDate' => date('Y-m-d H:i:s'),
					);
					
					//insert record
					$this->cportal->insert('BookingType', $data);

					//display success message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
					redirect('index.php/Common/BookingType/Create');
				}
			}
			else
			{
				$data = array(
					'Description' => $this->input->post('Description'),
					'GroupID' => $this->input->post('GroupCode'),
					'GroupCode' => $this->input->post('GroupCode'),
					'BTStatusID' => $this->input->post('Status'),
					'MaxBookHour' => $this->input->post('MaxBookHour'),
					'ViewOnly' => $this->input->post('ViewOnly'),
					'AutoApproveBooking' => $this->input->post('AutoApproveBooking'),
					'OtherFacility' => $this->input->post('OtherFacility'),
					'ManageBookAdmin' => $this->input->post('ManageBookAdmin'),
					'Schedule' => $this->input->post('ResetBooking'),
					'SDuration' => $this->input->post('ResetHour'),
					'DailyBooking' => $this->input->post('DailyBooking'),
					'CreatedBy' => $_SESSION['userid'],
					'CreatedDate' => date('Y-m-d H:i:s'),
				);
				
				//insert record
				$this->cportal->insert('BookingType', $data);

				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
				redirect('index.php/Common/BookingType/Create');
			}
        }
    }
	
	public function Detail($BookingTypeID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['btRecord'] = $this->booking_model->get_bookingType_record($BookingTypeID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Facilities/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
	public function Update($BookingTypeID)
	{
		//call the model
		$data['bookingTypeID'] = $BookingTypeID;
		$data['company'] = $this->header_model->get_Company();
        $data['maxBookHour'] = $this->booking_model->get_MaxBookHour();
		$data['btGroup'] = $this->booking_model->get_BTGroup();
        $data['btStatus'] = $this->booking_model->get_BTStatus();
        $data['btRecord'] = $this->booking_model->get_bookingType_record($BookingTypeID);    

        //set validation rules
		$this->form_validation->set_rules('Description', 'Description', 'trim|required');
        $this->form_validation->set_rules('Status', 'Status', 'callback_combo_check');
        $this->form_validation->set_rules('MaxBookHour', 'Max Book Hour', 'callback_combo_check');
        $this->form_validation->set_rules('ViewOnly', 'Owner View Only');
        $this->form_validation->set_rules('AutoApproveBooking', 'Auto Approve Booking');
        $this->form_validation->set_rules('OtherFacility', 'Other Facility');
        $this->form_validation->set_rules('ManageBookAdmin', 'Manage Booking (Admin)');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/Setup/Facilities/Update', $data);
				$this->load->view('Mgmt/footer');
			}
        }
        else
        {
            //validation succeed
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\facility';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$new_name = date("Ymdhis").'_'.$_FILES["ImgToShown"]['name'];
			$config['file_name'] = $new_name;
			$config['overwrite'] = TRUE;
			
			//load upload class library
			$this->load->library('upload', $config);

			if ($_FILES AND $_FILES['ImgToShown']['name'])
			{
				if (!$this->upload->do_upload('ImgToShown'))
				{
					// case - failure
					$upload_error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('msg','<script language=javascript>alert("'.$upload_error['error'].'");</script>');
					redirect('index.php/Common/BookingType/Update/'.$BookingTypeID);
				}
				else
				{
					// case - success
					$upload_data = $this->upload->data();
					$fileName = $upload_data['file_name'];
						 
					$this->thumb($upload_data,500,false);
					
					$data = array(
						'Description' => $this->input->post('Description'),
						'GroupID' => $this->input->post('GroupCode'),
						'GroupCode' => $this->input->post('GroupCode'),
						'BTStatusID' => $this->input->post('Status'),
						'MaxBookHour' => $this->input->post('MaxBookHour'),
						'ViewOnly' => $this->input->post('ViewOnly'),
						'AutoApproveBooking' => $this->input->post('AutoApproveBooking'),
						'OtherFacility' => $this->input->post('OtherFacility'),
						'ManageBookAdmin' => $this->input->post('ManageBookAdmin'),
						'Schedule' => $this->input->post('ResetBooking'),
						'SDuration' => $this->input->post('ResetHour'),
						'DailyBooking' => $this->input->post('DailyBooking'),
						'ImgToShown' => $fileName,
						'ModifiedBy' => $_SESSION['userid'],
						'ModifiedDate' => date('Y-m-d H:i:s'),
					);

					//update BookingType record
					$this->cportal->where('BookingTypeID', $BookingTypeID);
					$this->cportal->update('BookingType', $data);

					//display success message
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
					redirect('index.php/Common/BookingType/Update/'.$BookingTypeID);
				}
			}
			else
			{
				$data = array(
					'Description' => $this->input->post('Description'),
					'GroupID' => $this->input->post('GroupCode'),
					'GroupCode' => $this->input->post('GroupCode'),
					'BTStatusID' => $this->input->post('Status'),
					'MaxBookHour' => $this->input->post('MaxBookHour'),
					'ViewOnly' => $this->input->post('ViewOnly'),
					'AutoApproveBooking' => $this->input->post('AutoApproveBooking'),
					'OtherFacility' => $this->input->post('OtherFacility'),
					'ManageBookAdmin' => $this->input->post('ManageBookAdmin'),
					'Schedule' => $this->input->post('ResetBooking'),
					'SDuration' => $this->input->post('ResetHour'),
					'DailyBooking' => $this->input->post('DailyBooking'),
					'ModifiedBy' => $_SESSION['userid'],
					'ModifiedDate' => date('Y-m-d H:i:s'),
				);

				//update BookingType record
				$this->cportal->where('BookingTypeID', $BookingTypeID);
				$this->cportal->update('BookingType', $data);

				//display success message
				$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
				redirect('index.php/Common/BookingType/Update/' . $BookingTypeID);
			}
        }
	}
	
	function thumb($data,$thumb_size,$create_thumb)    
	{       
		$config['image_library'] = 'gd2';    
		$config['source_image'] = $data['full_path'];      
		$config['create_thumb'] = $create_thumb;    
		$config['width'] = $thumb_size;
		$config['height'] = $thumb_size;     
		$this->load->library('image_lib', $config);    
		$this->image_lib->resize();
	}
	
	public function Delete($BookingTypeID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['btRecord'] = $this->booking_model->get_bookingType_record($BookingTypeID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Setup/Facilities/Delete',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
    function delete_record($BookingTypeID)
    {
        //delete record
        $this->cportal->where('BookingTypeID', $BookingTypeID);
        $this->cportal->delete('BookingType');
        redirect('index.php/Common/BookingType/Index');
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
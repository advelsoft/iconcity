<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notice extends CI_Controller {
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
		$this->load->model('notice_model');
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
        $noticeList = $this->notice_model->get_notice_list();
        $data['noticeList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($noticeList) > 0) {
            $paginatedFiles = array_slice($noticeList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['noticeList'][] = array('title'=>$file['title'],
										      'noticeDate'=>$file['noticeDate'],
										      'dateTo'=>$file['dateTo'],
										      'createdBy'=>$file['createdBy'],
										      'createdDate'=>$file['createdDate'],
										      'noticeID'=>$file['noticeID']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Notice/Index";
        $config['total_rows'] = count($noticeList);
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
			$this->load->view('Mgmt/Notice/Index',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Notice/Index',$data);
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
        //set validation rules
        $this->form_validation->set_rules('Title', 'Title', 'trim|required');
		$this->form_validation->set_rules('NoticeDate', 'Date', 'required');
		$this->form_validation->set_rules('DateTo', 'Date', 'required');
        $this->form_validation->set_rules('Summary', 'Summary', 'required');
        $this->form_validation->set_rules('Description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Notice/Create');
			}
        }
        else
        {
			//validation succeed
			$desc = $this->input->post('Description');
			$title = $this->input->post('Title');
			$fileName = base_url().'application/uploads/notices/'.$title.'.jpg';
			$imagestrng = explode('src="', $desc);
			$data = explode('data-filename=', $imagestrng[1]);
			list($type, $data) = explode(';', $data[0]);
			list(, $data)      = explode(',', $data);
			$data = base64_decode($data);
			file_put_contents(APPPATH.'uploads/notices/'.$title.'.jpg', $data);
			
			//rearrange date
			$temp1 = explode('/', $this->input->post('NoticeDate'));
			$noticeDate = $temp1[2].'-'.$temp1[1].'-'.$temp1[0];
			
			$temp2 = explode('/', $this->input->post('DateTo'));
			$dateTo = $temp2[2].'-'.$temp2[1].'-'.$temp2[0];

            $data = array(
                'Title' => $this->input->post('Title'),
                'NoticeDate' => $noticeDate,
                'DateTo' => $dateTo,
                'Summary' => $this->input->post('Summary'),
                'Description' => $fileName,
                'CreatedBy' => $_SESSION['userid'],
                'CreatedDate' => date('Y-m-d H:i:s'),
            );
			
            //insert record
            $this->cportal->insert('Notices', $data);

            //display success message
            $this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
            redirect('index.php/Common/Notice/Index');
        }
    }
	
	public function Detail($NoticeID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['noticeRecord'] = $this->notice_model->get_notice_record($NoticeID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Notice/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/Notice/Detail',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function Update($NoticeID)
	{
		//call the model
		$data['noticeID'] = $NoticeID;
		$data['company'] = $this->header_model->get_Company();
        $data['noticeRecord'] = $this->notice_model->get_notice_record($NoticeID);    

        //set validation rules
		$this->form_validation->set_rules('Title', 'Title', 'trim|required');
		$this->form_validation->set_rules('NoticeDate', 'Date', 'required');
		$this->form_validation->set_rules('DateTo', 'Date', 'required');
        $this->form_validation->set_rules('Summary', 'Summary', 'required');
        $this->form_validation->set_rules('Description', 'Description', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Notice/Update', $data);
			}
        }
        else
        {
			$desc = $this->input->post('Description');
			$title = $this->input->post('Title');
			$fileName = base_url().'application/uploads/notices/'.$title.'.jpg';
			$imagestrng = explode('src="', $desc);
			$data = explode('data-filename=', $imagestrng[1]);
			list($type, $data) = explode(';', $data[0]);
			list(, $data)      = explode(',', $data);
			$data = base64_decode($data);
			file_put_contents(APPPATH.'uploads/notices/'.$title.'.jpg', $data);
			
			//rearrange date
			$temp1 = explode('/', $this->input->post('NoticeDate'));
			$noticeDate = $temp1[2].'-'.$temp1[1].'-'.$temp1[0];
			
			$temp2 = explode('/', $this->input->post('DateTo'));
			$dateTo = $temp2[2].'-'.$temp2[1].'-'.$temp2[0];
			
            $data = array(
                'Title' => $this->input->post('Title'),
                'NoticeDate' => $noticeDate,
                'DateTo' => $dateTo,
                'Summary' => $this->input->post('Summary'),
                'Description' => $fileName,
                'ModifiedBy' => $_SESSION['userid'],
                'ModifiedDate' => date('Y-m-d H:i:s'),
            );

			//update record
			$this->cportal->where('NoticeID', $NoticeID);
			$this->cportal->update('Notices', $data);

			//display success message
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
			redirect('index.php/Common/Notice/Index');
        }
	}
	
	public function Delete($NoticeID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['noticeRecord'] = $this->notice_model->get_notice_record($NoticeID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/Notice/Delete',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
    function delete_record($NoticeID)
    {
        //delete record
        $this->cportal->where('NoticeID', $NoticeID);
        $this->cportal->delete('Notices');
        redirect('index.php/Common/Notice/Index');
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
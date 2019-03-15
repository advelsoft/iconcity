<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class closedfeedbacks extends CI_Controller {
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
		$this->load->model('closedfeedback_model');
		$this->load->model('header_model');

		//check if login
		if (!$this->session->userdata('loginuser'))
        {
			$this->session->set_userdata('previous_page', uri_string());
            redirect(base_url().'index.php/Common/Login/Login');
        }		
	}
	
	public function Index($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $fbList = $this->closedfeedback_model->get_feedbacks_list();
        $data['feedbacksList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($fbList) > 0) {
            $paginatedFiles = array_slice($fbList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
				if($_SESSION['role'] == 'Mgmt'){
					$data['feedbacksList'][] = array('propertyNo'=>$file['propertyNo'],
													 'priority'=>$file['priority'],
													 'status'=>$file['status'],
													 'incidentType'=>$file['incidentType'],
													 'subject'=>$file['subject'],
													 'createdDate'=>$file['createdDate'],
													 'feedbackID'=>$file['feedbackID'],
												     'maxDate'=>$file['maxDate'],
													 'ownerName'=>$file['ownerName']);
				}
				else if($_SESSION['role'] == 'Tech'){
					$data['feedbacksList'][] = array('propertyNo'=>$file['propertyNo'],
													 'priority'=>$file['priority'],
													 'status'=>$file['status'],
													 'incidentType'=>$file['incidentType'],
													 'subject'=>$file['subject'],
													 'createdDate'=>$file['createdDate'],
													 'feedbackID'=>$file['feedbackID']);
				}
				else{
					$data['feedbacksList'][] = array('feedbackID'=>$file['feedbackID'],
												     'status'=>$file['status'],
												     'incidentType'=>$file['incidentType'],
												     'subject'=>$file['subject'],
												     'createdDate'=>$file['createdDate'],
												     'maxDate'=>$file['maxDate']);
				}
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/ClosedFeedbacks/Index";
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
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Feedbacks/ClosedFeedbacks/Index',$data);
		}
		else if($_SESSION['role'] == 'Tech'){
			$this->load->view('Tech/header',$data);
			$this->load->view('Tech/nav');
			$this->load->view('Tech/footer');
			$this->load->view('Tech/Feedbacks/ClosedFeedbacks/Index',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Feedbacks/ClosedFeedbacks/Index',$data);
		}
	}
	
	public function Detail($UID)
	{
		//call the model
		$data['UID'] = $UID;
		$data['company'] = $this->header_model->get_Company();
		$data['priority'] = $this->closedfeedback_model->get_Priority();
		$data['assignTo'] = $this->closedfeedback_model->get_AssignTo();
		$data['technician'] = $this->closedfeedback_model->get_Technician();
		$data['closedFeedbacks'] = $this->closedfeedback_model->get_feedbacks_record($UID);
		$data['replyFeedbacks'] = $this->closedfeedback_model->get_replyfeedbacks_record($UID);
		
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Feedbacks/ClosedFeedbacks/Detail',$data);
		}
		else if($_SESSION['role'] == 'Tech'){
			$this->load->view('Tech/header',$data);
			$this->load->view('Tech/nav');
			$this->load->view('Tech/footer');
			$this->load->view('Tech/Feedbacks/ClosedFeedbacks/Detail',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Feedbacks/ClosedFeedbacks/Detail',$data);
		}
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
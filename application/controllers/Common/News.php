<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news extends CI_Controller {
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
		$this->load->library('Curl');
		$this->load->library('PHPRequests');
		
		//load the model
		$this->load->model('news_model');
		$this->load->model('header_model');
		
		//check if login
		if (!isset($_SESSION['role']))
        {
        	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        	$this->session->set_userdata('JUMP_URL', $actual_link);
        	$this->session->set_flashdata('msg', '<script language=javascript>alert("Please login before proceeding");</script>');
            redirect(base_url());
        }
	}

	public function Index($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		if($_SESSION['role'] == 'Mgmt'){
			$newsList = $this->news_model->get_news_list_mgmt();
		} else {
			$newsList = $this->news_model->get_news_list();
		}
        
        $data['newsList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();
		
        if (count($newsList) > 0) {
            $paginatedFiles = array_slice($newsList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['newsList'][] = array('title'=>$file['title'],
										    'createdBy'=>$file['createdBy'],
										    'createdDate'=>$file['createdDate'],
										    'newsID'=>$file['newsID'],
										    'Publish'=>$file['Publish'],
										    'description'=>$file['description']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/News/Index";
        $config['total_rows'] = count($newsList);
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
		//var_dump ($data['newsList'][0]['newsID']); die();
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/News/Index',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/News/Index',$data);
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $data['newsType'] = $this->news_model->get_NewsType();

        //set validation rules
        $this->form_validation->set_rules('Title', 'Title', 'trim|required');
        $this->form_validation->set_rules('Summary', 'Summary', 'required');
        $this->form_validation->set_rules('NewsType', 'News Type', 'callback_combo_check|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/News/Create',$data);
			}
        }
        else
        {
			//validation succeed
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\news';
			$config['allowed_types'] = 'png|jpg|jpeg|pdf';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			$fileName1 = NULL;
			$fileName2 = NULL;
			$fileName3 = NULL;
			$fileName4 = NULL;

			if(!empty($_FILES['Attachment1'])){
				$fileName1 = base_url().'application/uploads/news/'.date("Ymdhis").'_'.$_FILES["Attachment1"]['name'];
			}
			
			if(!empty($_FILES['Attachment2'])){
				$fileName2 = base_url().'application/uploads/news/'.date("Ymdhis").'_'.$_FILES["Attachment2"]['name'];
			}
			
			if(!empty($_FILES['Attachment3'])){
				$fileName3 = base_url().'application/uploads/news/'.date("Ymdhis").'_'.$_FILES["Attachment3"]['name'];
			}
			
			if(!empty($_FILES['Attachment4'])){
				$fileName4 = base_url().'application/uploads/news/'.date("Ymdhis").'_'.$_FILES["Attachment4"]['name'];				
			}
			
			//rearrange date
			$temp1 = explode('/', $this->input->post('NewsfeedDate'));
			$newsfeedDate = $temp1[2].'-'.$temp1[1].'-'.$temp1[0];
			
			$temp2 = explode('/', $this->input->post('PublishDateFrom'));
			$dateFrom = $temp2[2].'-'.$temp2[1].'-'.$temp2[0];
			
			$temp3 = explode('/', $this->input->post('PublishDateTo'));
			$dateTo = $temp3[2].'-'.$temp3[1].'-'.$temp3[0];

			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			//get Type
			if($this->input->post('NewsType') == '1'){
				$newsType = 'news';
			}
			else if($this->input->post('NewsType') == '2'){
				$newsType = 'event';
			}
			else if($this->input->post('NewsType') == '3'){
				$newsType = 'notice';
			}
			
			//no file uploaded
			if($_FILES["Attachment1"]["error"] == 4){
				$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UserIdNo' => $_SESSION['userid'], 'Title' => $this->input->post('Title'), 'Summary' =>$this->input->post('Summary'), 'Type' => $newsType, 'PublishDateFrom' => $dateFrom, 'PublishTimeFrom' => date("his"), 'PublishDateTo' => $dateTo, 'NewsfeedDate' => $newsfeedDate, 'Publish' => $this->input->post('Publish'));
				$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeAddCondo';
				$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
				$response = Requests::post($url, $headers, json_encode($jsonData));
				$body = json_decode($response->body, true);
				
				foreach($body as $key => $value)
				{
					if($key == 'Req'){
						$CondoSeqNo = $value['CondoSeqNo'];
					}
					else if($key == 'Resp'){
						$Status = $value['Status'];
						$FailedReason = $value['FailedReason'];
						$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
					} else if($key == 'Result'){
						$NoticeId = $value['NoticeId'];
					}
				}

				$publish = $this->input->post('Publish');
				if($publish){
					$email = $this->input->post('SentEmail');
					if($email){
						$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'NoticeId' => $NoticeId, 'CustType' => 'O', 'SendTo' =>'1', 'UserIdNo' => '1');
						$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeCondoEmail';
						$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
						$response = Requests::post($url, $headers, json_encode($jsonData));
						$body1 = json_decode($response->body, true);
					}
				}
				
				//display message
				if($Status == 'F'){
					$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
					redirect('index.php/Common/News/Index');
				}
				else{
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
					redirect('index.php/Common/News/Index');
				}
			}
			else{
				$maxImg = 4;
				$img = 1;
				for ($img = 1; $img <= 4; $img++)
				{
					if(!empty($_FILES['Attachment'.$img]))
					{
						$config['file_name'] = date("Ymdhis").'_'.$_FILES['Attachment'.$img]['name'];
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('Attachment'.$img))
						{
							// case - failure
							$upload_error = array('error' => $this->upload->display_errors());
							$this->session->set_flashdata('msg','<script language=javascript>alert("Attachment'.$img.$upload_error['error'].'");</script>');
							redirect('index.php/Common/News/Create');
						}
						else
						{
							// case - success
							$upload_data = $this->upload->data();
						}
					}
				}
				
				$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UserIdNo' => $_SESSION['userid'], 'Title' => $this->input->post('Title'), 'Summary' =>$this->input->post('Summary'), 'Type' => $newsType, 'PublishDateFrom' => $dateFrom, 'PublishTimeFrom' => date("his"), 'PublishDateTo' => $dateTo, 'NewsfeedDate' => $newsfeedDate, 'Publish' => $this->input->post('Publish'),
								  'Attachment1' => $fileName1, 'Attachment2' => $fileName2, 'Attachment3' => $fileName3, 'Attachment4' => $fileName4);
				$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeAddCondo';
				$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
				$response = Requests::post($url, $headers, json_encode($jsonData));
				$body = json_decode($response->body, true);

				foreach($body as $key => $value)
				{
					if($key == 'Req'){
						$CondoSeqNo = $value['CondoSeqNo'];
					}
					else if($key == 'Resp'){
						$Status = $value['Status'];
						$FailedReason = $value['FailedReason'];
						$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
					} else if($key == 'Result'){
						$NoticeId = $value['NoticeId'];
					}
				}

				$publish = $this->input->post('Publish');
				if($publish){
					$email = $this->input->post('SentEmail');
					if($email){
						$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'NoticeId' => $NoticeId, 'CustType' => 'O', 'SendTo' =>'1', 'UserIdNo' => '1');
						$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeCondoEmail';
						$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
						$response = Requests::post($url, $headers, json_encode($jsonData));
						$body1 = json_decode($response->body, true);
					}
				}
				
				//display message
				if($Status == 'F'){
					$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
					redirect('index.php/Common/News/Index');
				}
				else{
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Added");</script>');
					redirect('index.php/Common/News/Index');
				}
			}
        }
    }
	
	public function Detail($NewsID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['newsRecord'] = $this->news_model->get_news_record2($NewsID);
		
		if(empty($data['newsRecord'])){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("This news/article is unavailable");</script>');
			redirect('index.php/Common/News/Index');
		}

		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/News/Detail',$data);
			$this->load->view('Mgmt/footer');
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/News/Detail',$data);
			$this->load->view('User/footer');
		}
	}
	
	public function Update($NewsID)
	{
		//call the model
		$data['newsID'] = $NewsID;
		$data['company'] = $this->header_model->get_Company();
        $data['newsType'] = $this->news_model->get_NewsType();
        $data['newsRecord'] = $this->news_model->get_news_record($NewsID);    

        //set validation rules
		$this->form_validation->set_rules('Title', 'Title', 'trim|required');
        $this->form_validation->set_rules('Summary', 'Summary', 'required');
        $this->form_validation->set_rules('NewsType', 'News Type', 'callback_combo_check|required');

        if ($this->form_validation->run() == FALSE)
        {   
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/News/Update', $data);
			}
        }
        else
        {
			//set preferences
			$config['upload_path'] = APPPATH.'uploads\news';
			$config['allowed_types'] = 'png|jpg|jpeg|pdf';
			$config['overwrite'] = TRUE;

			//load upload class library
			$this->load->library('upload', $config);
			
			$fileName1 = NULL;
			$fileName2 = NULL;
			$fileName3 = NULL;
			$fileName4 = NULL;

			if(!empty($_FILES['Attachment1'])){
				$fileName1 = base_url().'application/uploads/news/'.date("Ymdhis").'_'.$_FILES["Attachment1"]['name'];
			}
			
			if(!empty($_FILES['Attachment2'])){
				$fileName2 = base_url().'application/uploads/news/'.date("Ymdhis").'_'.$_FILES["Attachment2"]['name'];
			}
			
			if(!empty($_FILES['Attachment3'])){
				$fileName3 = base_url().'application/uploads/news/'.date("Ymdhis").'_'.$_FILES["Attachment3"]['name'];
			}
			
			if(!empty($_FILES['Attachment4'])){
				$fileName4 = base_url().'application/uploads/news/'.date("Ymdhis").'_'.$_FILES["Attachment4"]['name'];				
			}

			//rearrange date
			$temp1 = explode('/', $this->input->post('NewsfeedDate'));
			$newsfeedDate = $temp1[2].'-'.$temp1[1].'-'.$temp1[0];
			
			$temp2 = explode('/', $this->input->post('PublishDateFrom'));
			$dateFrom = $temp2[2].'-'.$temp2[1].'-'.$temp2[0];
			
			$temp3 = explode('/', $this->input->post('PublishDateTo'));
			$dateTo = $temp3[2].'-'.$temp3[1].'-'.$temp3[0];

			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			//get Type
			if($this->input->post('NewsType') == '1'){
				$newsType = 'news';
			}
			else if($this->input->post('NewsType') == '2'){
				$newsType = 'event';
			}
			else if($this->input->post('NewsType') == '3'){
				$newsType = 'notice';
			}

			//no file uploaded
			if($_FILES["Attachment1"]["error"] == 4){
				$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UserIdNo' => $_SESSION['userid'], 'NoticeId' => $NewsID, 'Title' => $this->input->post('Title'), 'Summary' =>$this->input->post('Summary'), 'Type' => $newsType, 'PublishDateFrom' => $dateFrom, 'PublishTimeFrom' => date("his"), 'PublishDateTo' => $dateTo, 'NewsfeedDate' => $newsfeedDate, 'Publish' => $this->input->post('Publish'));
				$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeEditCondo';
				$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
				$response = Requests::post($url, $headers, json_encode($jsonData));
				$body = json_decode($response->body, true);
				
				foreach($body as $key => $value)
				{
					if($key == 'Req'){
						$CondoSeqNo = $value['CondoSeqNo'];
					}
					else if($key == 'Resp'){
						$Status = $value['Status'];
						$FailedReason = $value['FailedReason'];
						$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
					} else if($key == 'Result'){
						$NoticeId = $value['NoticeId'];
					}
				}

				$publish = $this->input->post('Publish');
				if($publish){
					$email = $this->input->post('SentEmail');
					if($email){
						$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'NoticeId' => $NoticeId, 'CustType' => 'O', 'SendTo' =>'1', 'UserIdNo' => '1');
						$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeCondoEmail';
						$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
						$response = Requests::post($url, $headers, json_encode($jsonData));
						$body1 = json_decode($response->body, true);
					}
				}

				//display message
				if($Status == 'F'){
					$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
					redirect('index.php/Common/News/Index');
				}
				else{
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
					redirect('index.php/Common/News/Index');
				}
			}
			else{
				$maxImg = 4;
				$img = 1;
				for ($img = 1; $img <= 4; $img++)
				{
					if(!empty($_FILES['Attachment'.$img]))
					{
						$config['file_name'] = date("Ymdhis").'_'.$_FILES['Attachment'.$img]['name'];
						$this->upload->initialize($config);

						if (!$this->upload->do_upload('Attachment'.$img))
						{
							// case - failure
							$upload_error = array('error' => $this->upload->display_errors());
							$this->session->set_flashdata('msg','<script language=javascript>alert("'.$upload_error['error'].'");</script>');
							redirect('index.php/Common/News/Update/'.$NewsID);
						}
						else
						{
							// case - success
							$upload_data = $this->upload->data();
						}
					}
				}
				$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UserIdNo' => $_SESSION['userid'], 'NoticeId' => $NewsID, 'Title' => $this->input->post('Title'), 'Summary' =>$this->input->post('Summary'), 'Type' => $newsType, 'PublishDateFrom' => $dateFrom, 'PublishTimeFrom' => date("his"), 'PublishDateTo' => $dateTo, 'NewsfeedDate' => $newsfeedDate, 'Publish' => $this->input->post('Publish'), 'Attachment1' => $fileName1, 'Attachment2' => $fileName2, 'Attachment3' => $fileName3, 'Attachment4' => $fileName4);
				$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeEditCondo';
				$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
				$response = Requests::post($url, $headers, json_encode($jsonData));
				$body = json_decode($response->body, true);

				foreach($body as $key => $value)
				{
					if($key == 'Req'){
						$CondoSeqNo = $value['CondoSeqNo'];
					}
					else if($key == 'Resp'){
						$Status = $value['Status'];
						$FailedReason = $value['FailedReason'];
						$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
					} else if($key == 'Result'){
						$NoticeId = $value['NoticeId'];
					}
				}

				$publish = $this->input->post('Publish');
				if($publish){
					$email = $this->input->post('SentEmail');
					if($email){
						$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'NoticeId' => $NoticeId, 'CustType' => 'O', 'SendTo' =>'1', 'UserIdNo' => '1');
						$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/NoticeCondoEmail';
						$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
						$response = Requests::post($url, $headers, json_encode($jsonData));
						$body1 = json_decode($response->body, true);
					}
				}
				
				//display message
				if($Status == 'F'){
					$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
					redirect('index.php/Common/News/Index');
				}
				else{
					$this->session->set_flashdata('msg', '<script language=javascript>alert("Updated");</script>');
					redirect('index.php/Common/News/Index');
				}
			}
        }
	}

	public function Delete($NewsID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['newsRecord'] = $this->news_model->get_news_record($NewsID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/News/Delete',$data);
			$this->load->view('Mgmt/footer');
		}
	}
	
    function delete_record($NewsID)
    {
        //delete record
        $this->jompay->where('NewsfeedID', $NewsID);
        $this->jompay->delete('Newsfeed');
        redirect('index.php/Common/News/Index');
    }
    
	public function News($NewsID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['newsRecord'] = $this->news_model->get_news_record($NewsID);
		
		//load the view
		$this->load->view('Default/News',$data);
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

	public function Viewers($NewsID)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['viewers'] = $this->news_model->get_viewer_list($NewsID);
		
		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/News/Viewers',$data);
			$this->load->view('Mgmt/footer');
		}
	}
}?>
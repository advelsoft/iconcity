<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class outstanding extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('Curl');
		$this->load->library('PHPRequests');
		
		//load the model
		$this->load->model('outstanding_model');
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
        $osList = $this->outstanding_model->get_os_list();
		$data['bankLog'] = $this->outstanding_model->get_BankLog();

        $data['osList'] = array();
        $offset = ($page - 1) * 100;
        $paginatedFiles = array();

        if (count($osList) > 0) {
            $paginatedFiles = array_slice($osList, $offset, 100, true);
			
			foreach ($osList as $osL) {
				$data['totalGross'] = $osL['totalGross'];
				$data['totalOpen'] = $osL['totalOpen'];
				$data['totalNet'] = $osL['totalGross']+$osL['totalOpen'];
				$data['billerCode'] = $osL['billerCode'];
			}
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['osList'][] = array('custType'=>$file['custType'],
										  'docNo'=>$file['docNo'],
										  'trxnDate'=>$file['trxnDate'],
										  'desc'=>$file['desc'],
										  'dueDate'=>$file['dueDate'],
										  'amt'=>$file['amt'],
										  'floatAmt'=>$file['floatAmt'],
										  'ref1'=>$file['ref1']);
            }
			$this->array_sort_by_column($data['osList'], 'dueDate');
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/Index";
        $config['total_rows'] = count($osList);
        $config['per_page'] = 100;
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
			$this->load->view('Mgmt/Setup/Outstanding/Index',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/Index',$data);
		}
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('tmpDocNo', 'tmpDocNo', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Setup/Outstanding/Index');
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Outstanding/Index');
			}
        }
        else
        {
			//validation succeed
			//get propertyNo
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', GLOBAL_CONDOSEQ);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			//assign cust type
			if($user[0]->GROUPID == '2'){
				$custType = 'O';//owner
			}
			else{
				$custType = 'T';//tenant
			}
			
			$temp = explode('|', $this->input->post('tmpDocNo'));
			$j = 1;
			for ($i = 0; $i < count($temp)-1; $i++){
				$docNos[$i] = array('DocNo' => $temp[$i]);
			}

			$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => GLOBAL_CONDOSEQ, 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'],
							  'CustType' => $custType, 'Bills' => $docNos);

			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/JompayAdd';
			$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
			$response = Requests::post($url, $headers, json_encode($jsonData));
			$body = json_decode($response->body, true);
			//echo '<pre>';
			//print_r($body);
			
			foreach($body as $key => $value)
			{
				if($key == 'Req'){
					$CondoSeqNo = $value['CondoSeqNo'];
					$UnitSeqNo = $value['UnitSeqNo'];
					$UserIdNo = $value['UserIdNo'];
					$UserTokenNo = $value['UserTokenNo'];
					$CustType = $value['CustType'];
				}
				else if($key == 'Bills'){
					foreach($value as $k => $v)
					{
						$DocNo = $v['DocNo'];
					}
				}
				else if($key == 'Resp'){
					$Status = $value['Status'];
					$FailedReason = $value['FailedReason'];
					$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
				}
				else if($key == 'Result'){
					$Date = $value['Date'];
					$BillerCode = $value['BillerCode'];
					$Ref1 = $value['Ref1'];
					$Amount = $value['Amount'];
					$TotalBills = $value['TotalBills'];
				}
			}
			
			if($Status != ''){
				if($Status == 'F'){
					$this->session->set_flashdata('jompay', '<script language=javascript>alert("'.$FailedReason.'");</script>');
					redirect('index.php/Common/Outstanding/Index');	
				}
				else{
					if($Ref1 != ''){
						//redirect to Ref1 page
						redirect('index.php/Common/Outstanding/JomPayRef/'.$Ref1);
					}
					else{
						$this->session->set_flashdata('jompay', '<script language=javascript>alert("No Ref1 has been created.");</script>');
						redirect('index.php/Common/Outstanding/Index');	
					}
				}
			}
			else{
				$this->session->set_flashdata('jompay', '<script language=javascript>alert("Sorry for inconvenience, system is under maintenance...");</script>');
				redirect('index.php/Common/Outstanding/Index');
			}
        }
    }
	
	public function ResetRef1()
	{
		//get propertyNo
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
        $user = $query->result();
		
		//get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', GLOBAL_CONDOSEQ);
		$query = $this->jompay->get();
        $condo = $query->result();
		
		//assign cust type
		if($user[0]->GROUPID == '2'){
			$custType = 'O';//owner
		}
		else{
			$custType = 'T';//tenant
		}
		
		$temp = explode('|', $this->input->post('tmpRef1'));
		for ($i = 0; $i < count($temp)-1; $i++){
			$ref1 = $temp[$i];
			
			$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => GLOBAL_CONDOSEQ, 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'], 'CustType' => $custType, 'Ref1' =>$ref1);

			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/JompayCancel';
			$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
			$response = Requests::post($url, $headers, json_encode($jsonData));
			$body = json_decode($response->body, true);
		
			//echo '<pre>';
			//print_r($body);
			
			foreach($body as $key => $value)
			{
				if($key == 'Req'){
					$Ref1 = $value['Ref1'];
				}
				else if($key == 'Resp'){
					$Status = $value['Status'];
					$FailedReason = $value['FailedReason'];
					$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
				}
			}
		}
		
		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect('index.php/User/Outstanding/Index');
		}
		else{
			//redirect to Outstanding page
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Ref1 has been reset.");</script>');
			redirect('index.php/Common/Outstanding/Index');
		}
	}
	
	public function Lists($page=1)
	{
		$data['company'] = $this->header_model->get_Company();
		$osList = $this->outstanding_model->get_os_list();
		$data['totalGross'] = $this->outstanding_model->get_totalGross();
		$data['totalOpen'] = $this->outstanding_model->get_totalOpen();
        $data['osList'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($osList) > 0) {
            $paginatedFiles = array_slice($osList, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['osList'][] = array('docNo'=>$file['docNo'],
										  'trxnDate'=>$file['trxnDate'],
										  'desc'=>$file['desc'],
										  'dueDate'=>$file['dueDate'],
										  'amt'=>$file['amt']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/Lists";
        $config['total_rows'] = count($osList);
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
			$this->load->view('Mgmt/Setup/Outstanding/List',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/List',$data);
		}
	}
	
	public function JomPayRef($ref1)
	{
		//call the model
		$data['Ref1'] = $ref1;
		$data['company'] = $this->header_model->get_Company();
		$data['jomPayRef'] = $this->outstanding_model->get_jompay_ref($ref1);
		$data['bankLog'] = $this->outstanding_model->get_BankLog();
		
		//load the view
		$this->load->view('User/header',$data);
		$this->load->view('User/nav');
		$this->load->view('User/footer');
		$this->load->view('User/Outstanding/JomPayRef', $data);
	}
	
	public function JomPayBank($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['jomBank'] = $this->outstanding_model->get_JomBank();
        $jomBank = $this->outstanding_model->get_jompay_bank();
        $data['jomBankList'] = array();
        $offset = ($page - 1) * 20;
        $paginatedFiles = array();

        if (count($jomBank) > 0) {
            $paginatedFiles = array_slice($jomBank, $offset, 20, true);
        }
		
		if ($paginatedFiles) {
			foreach ($paginatedFiles as $file) {
                $data['jomBankList'][] = array('bankName'=>$file['bankName'],
											   'bankCode'=>$file['bankCode'],
											   'bankURL'=>$file['bankURL'],
											   'bankImg'=>$file['bankImg']);
				}
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/JomPayBank";
        $config['total_rows'] = count($jomBank);
        $config['per_page'] = 20;
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

		//set validation rules
        $this->form_validation->set_rules('JomPayBank', 'JomPayBank', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Setup/Outstanding/JomPayBank',$data);	
			}
			else{
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Outstanding/JomPayBank', $data);
			}
        }
        else
        {
			//validation succeed
			//get user loginid
			$this->cportal->where('UserID',$_SESSION['userid']);
			$this->cportal->from('Users');
			$query = $this->cportal->get();
			$user = $query->result();

			//get bank url
			$this->jompay->where('SHORTBANKNAME',$this->input->post('tmpBankName'));
			$this->jompay->from('JomBank');
			$query = $this->jompay->get();
			$bank = $query->result();		
			
			//check if exist or not
			$this->cportal->where('LoginID',$user[0]->LOGINID);
			$this->cportal->from('BankLog');
			$query = $this->cportal->get();
			$result = $query->result();
			
			if(count($result) == 0){
				 $data = array(
					'LoginID' => $user[0]->LOGINID,
					'BankName' => $this->input->post('tmpBankName'),
				);

				//insert record
				$this->cportal->insert('BankLog', $data);
			}
            else{
				//update record
				$this->cportal->set('BankName', $this->input->post('tmpBankName'));
				$this->cportal->where('LoginID', $user[0]->LOGINID);
				$this->cportal->update('BankLog');
			}
			
            //display message
            redirect($bank[0]->BANKURL);
        }
	}
	
	public function Statement()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['userType'] = $this->outstanding_model->get_UserType();
		
		//check cust type
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
		$user = $query->result();

		//load the view
		if($_SESSION['role'] == 'Mgmt'){
			$this->load->view('Mgmt/header',$data);
			$this->load->view('Mgmt/nav');
			$this->load->view('Mgmt/footer');
			$this->load->view('Mgmt/Setup/Outstanding/Statement',$data);
		}
		else{
			if($user[0]->GROUPID == '2'){//owner
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Outstanding/StatementO',$data);
			}
			else{//tenant
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Outstanding/StatementT',$data);
			}
		}
	}
	
	public function GenerateStatement()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $statement = $this->outstanding_model->get_stmt_detail();
        $data['userType'] = $this->outstanding_model->get_UserType();
		
		//check cust type
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
		$user = $query->result();
		
		//set validation rules
		if($user[0]->GROUPID == '2'){//owner
			//$this->form_validation->set_rules('CustType', 'CustType', 'required');
			$this->form_validation->set_rules('DateFrom', 'DateFrom', 'required');
		}
		else{//tenant
			$this->form_validation->set_rules('DateFrom', 'DateFrom', 'required');
		}

		if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			if($_SESSION['role'] == 'Mgmt'){
				$this->load->view('Mgmt/header',$data);
				$this->load->view('Mgmt/nav');
				$this->load->view('Mgmt/footer');
				$this->load->view('Mgmt/Setup/Outstanding/Statement',$data);
			}
			else{
				if($user[0]->GROUPID == '2'){//owner
					$this->load->view('User/header',$data);
					$this->load->view('User/nav');
					$this->load->view('User/footer');
					$this->load->view('User/Outstanding/StatementO',$data);
				}
				else{//tenant
					$this->load->view('User/header',$data);
					$this->load->view('User/nav');
					$this->load->view('User/footer');
					$this->load->view('User/Outstanding/StatementT',$data);
				}
			}
        }
        else
        {
			//validation succeed
			header("location: ".$statement."");
		}
	}
	
	public function History($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $osHistory = $this->outstanding_model->get_os_history();
        $data['osHistory'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($osHistory) > 0) {
            $paginatedFiles = array_slice($osHistory, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['osHistory'][] = array('desc'=>$file['desc'],
											 'amt'=>$file['amt'],
											 'datepaid'=>$file['datepaid'],
											 'receiptno'=>$file['receiptno']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/History";
        $config['total_rows'] = count($osHistory);
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
			$this->load->view('Mgmt/Setup/Outstanding/History',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/History',$data);
		}
	}

	public function GenerateHistory($ReceiptNo)
	{
		//get propertyNo
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
        $user = $query->result();
		
		//get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', GLOBAL_CONDOSEQ);
		$query = $this->jompay->get();
        $condo = $query->result();
		
		//assign cust type
		if($user[0]->GROUPID == '2'){
			$custType = 'O';//owner
		}
		else{
			$custType = 'T';//tenant
		}
		
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => GLOBAL_CONDOSEQ, 'UnitSeqNo' => trim($user[0]->UNITSEQ), 
						  'UserIdNo' => $_SESSION['userid'], 'ReceiptNo' => $ReceiptNo);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/ReceiptRead';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		//echo '<pre>';
		//print_r($body);
		$totalGross = "";
		$totalOpen = "";

		foreach($body as $key => $value)
		{
			if($key == 'Req'){
				$CondoSeqNo = $value['CondoSeqNo'];
				$UnitSeqNo = $value['UnitSeqNo'];
			}
			else if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
			else if($key == 'Result'){
				$FileUrl = $value['FileUrl'];
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect('index.php/User/Home/Index');
		}
		else{
			header("location: ".$FileUrl."");
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
	
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
	{
		$sort_col = array();
		foreach ($arr as $key=> $row)
		{
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}
}?>
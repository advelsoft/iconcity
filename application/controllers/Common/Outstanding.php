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
		if (!isset($_SESSION['condoseq']))
        {
        	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        	$this->session->set_userdata('JUMP_URL', $actual_link);
        	$this->session->set_flashdata('msg', '<script language=javascript>alert("Please login before proceeding");</script>');
            redirect(base_url().'index.php');
        }
	}

	public function Index($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $osList = $this->outstanding_model->get_os_list();
		$data['osList'] = array();
        $offset = ($page - 1) * 100;
        $paginatedFiles = array();

        if (count($osList) > 0) {
            $paginatedFiles = array_slice($osList, $offset, 100, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['osList'][] = array('custType'=>$file['custType'],
										  'docNo'=>$file['docNo'],
										  'trxnDate'=>$file['trxnDate'],
										  'desc'=>$file['desc'],
										  'dueDate'=>$file['dueDate'],
										  'amt'=>$file['amt']);
				$data['totalGross'] = $file['totalGross'];
				$data['totalOpen'] = $file['totalOpen'];
            }
        }
// echo "<pre>";
// print_r($data['osList']); die();
        $data['pending'] = $this->outstanding_model->get_pending_list();
		$pending = $this->outstanding_model->get_pending_list();
		$data['pending'] = array();
        $offset = ($page - 1) * 100;
        $paginatedFiles1 = array();

        if (count($pending) > 0) {
            $paginatedFiles1 = array_slice($pending, $offset, 100, true);
        }
		if ($paginatedFiles1) {
            foreach ($paginatedFiles1 as $file) {
                $data['pending'][] = array('bundleRef'=>$file['bundleRef'],
										   'date'=>$file['date'],
										   'amount'=>$file['amount'],
										   'totalBills'=>$file['totalBills'],
										   'ref1'=>$file['ref1'],
										   'billerCode'=>$file['billerCode']);
            }
        }
		
		$data_view = array(
			"tab1" => $this->load->view('User/Outstanding/Outstanding', $data, TRUE),
			"tab2" => $this->load->view('User/Outstanding/Pending', $data, TRUE)
		);

        //load the view
		$this->load->view('User/header',$data);
		$this->load->view('User/nav');
		$this->load->view('User/footer');
		$this->load->view('User/Outstanding/Index',$data_view);
	}
	
	public function Bills()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();

		//set validation rules
        $this->form_validation->set_rules('bundleRef', 'bundleRef', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/Pending');
        }
        else
        {
			//validation succeed
			$bundleRef = $this->input->post('bundleRef');
			$data['bills'] = $this->outstanding_model->get_bills_list($bundleRef);

			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/Pending');
        }
    }
	
	public function PayInfo()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		$data['userDetail'] = $this->outstanding_model->get_user_detail();
		
		$bills = $this->input->post('tmpDocNo');
		if(isset($bills)){
			$bundleRef = $this->outstanding_model->get_bundle_ref($bills);
			$data['bundleRef'] = $bundleRef['bundleRef'];
			$data['amount'] = $bundleRef['amount'];
			$data['totalBills'] = $bundleRef['totalBills'];
		}
		else{
			$data['bundleRef'] = $this->input->post('bundleRef');
			$data['amount'] = $this->input->post('amount');
			$data['totalBills'] = $this->input->post('totalBills');
		}
		
		$this->load->view('User/header',$data);
		$this->load->view('User/nav');
		$this->load->view('User/footer');
		$this->load->view('User/Outstanding/PaymentInfo',$data);
	}
	
	public function Create()
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
		
		//set validation rules
        $this->form_validation->set_rules('bundleRef', 'bundleRef', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            //validation fail
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/PaymentInfo');
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
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			//assign cust type
			if($user[0]->GROUPID == '2'){
				$custType = 'O';//owner
			}
			else{
				$custType = 'T';//tenant
			}

			$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'],
							  'CustType' => $custType, 'BundleReference' => $this->input->post('BundleReference'));

			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundleJompayAdd';
			$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
			$response = Requests::post($url, $headers, json_encode($jsonData));
			$body = json_decode($response->body, true);
			
			foreach($body as $key => $value)
			{
				if($key == 'Req'){
					$CondoSeqNo = $value['CondoSeqNo'];
					$UnitSeqNo = $value['UnitSeqNo'];
					$UserIdNo = $value['UserIdNo'];
					$UserTokenNo = $value['UserTokenNo'];
					$CustType = $value['CustType'];
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
			
			if($Status == 'F'){
				$this->session->set_flashdata('jompay', '<script language=javascript>alert("'.$FailedReason.'");</script>');
				redirect('index.php/Common/Outstanding/PayInfo');	
			}
			else{
				$data['billerCode'] = $BillerCode;
				$data['ref1'] = $Ref1;
				$data['amount'] = $Amount;
				$data['bundleRef'] = $this->input->post('BundleReference');
				$data['bankLog'] = $this->outstanding_model->get_BankLog();
				
				$this->load->view('User/header',$data);
				$this->load->view('User/nav');
				$this->load->view('User/footer');
				$this->load->view('User/Outstanding/JomPayRef',$data);
			}
        }
    }
	
	public function PayStatus()
	{
		$data['company'] = $this->header_model->get_Company();
		
		$data['status'] = $_POST['Status'];
		$data['sAmt'] = $_POST['SettlementAmount'];
		$data['payRef'] = $_POST['PaymentReference'];
		
		$this->load->view('User/header',$data);
		$this->load->view('User/nav');
		$this->load->view('User/footer');
		$this->load->view('User/Outstanding/PayStatus',$data);
		
		if($_POST['Status'] == 'Success'){
			//get propertyNo
			$this->cportal->from('Users');
			$this->cportal->where('USERID', $_SESSION['userid']);
			$query = $this->cportal->get();
			$user = $query->result();
			
			//get server, port
			$this->jompay->from('Condo');
			$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
			$query = $this->jompay->get();
			$condo = $query->result();
			
			//assign cust type
			if($user[0]->GROUPID == '2'){
				$custType = 'O';//owner
			}
			else{
				$custType = 'T';//tenant
			}

			$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'],
							  'CustType' => $custType, 'BundleReference' => $_POST['BundleReference'], 'PaymentReference' => $_POST['PaymentReference'], 'PaymentGateway' => 'revpay', 
							  'MerchantId' => $_POST['MerchantId'], 'PaymentMethod' => $_POST['PaymentMethod'], 'SettlementAmount' => $_POST['SettlementAmount']);
				  
			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundlePaid';
			$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
			$response = Requests::post($url, $headers, json_encode($jsonData));
			$body = json_decode($response->body, true);
			
			foreach($body as $key => $value)
			{
				if($key == 'Req'){
					$CondoSeqNo = $value['CondoSeqNo'];
					$UnitSeqNo = $value['UnitSeqNo'];
					$UserIdNo = $value['UserIdNo'];
					$UserTokenNo = $value['UserTokenNo'];
				}
				else if($key == 'Resp'){
					$Status = $value['Status'];
					$FailedReason = $value['FailedReason'];
					$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
				}
				else if($key == 'Result'){
					$ReceiptNo = $value['ReceiptNo'];
					$TrxnDate = $value['TrxnDate'];
					$Description = $value['Description'];
					$Amount = $value['Amount'];
					$Ref1 = $value['Ref1'];
				}
			}
			
			if($Status == 'F'){
				$this->session->set_flashdata('paid', '<script language=javascript>alert("'.$FailedReason.'");</script>');
				//redirect('index.php/Common/Outstanding/Index');	
			}
			else{
				return;
			}
		}
	}
	
	public function ResetRef1($type)
	{
		//get propertyNo
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
        $user = $query->result();
		
		//get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
		$query = $this->jompay->get();
        $condo = $query->result();
		
		//assign cust type
		if($user[0]->GROUPID == '2'){
			$custType = 'O';//owner
		}
		else{
			$custType = 'T';//tenant
		}
		
		$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 
							  'UserIdNo' => $_SESSION['userid'], 'CustType' => $custType, 'BundleReference' =>$this->input->post('bundleRef'));

		if($type == '1'){ //Jompay
			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundleJompayCancel';
		}
		else if($type == '2') { //others
			$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundleCancel';
		}
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		
		foreach($body as $key => $value)
		{
			if($key == 'Req'){
				$BundleReference = $value['BundleReference'];
			}
			else if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
		}
		
		if($Status == 'F'){
			$this->session->set_flashdata('jompay', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect('index.php/Common/Outstanding/Index');
		}
		else{
			//redirect to Outstanding page
			$this->session->set_flashdata('jompay', '<script language=javascript>alert("Payment has been cancelled.");</script>');
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
			$this->form_validation->set_rules('CustType', 'CustType', 'required');
			$this->form_validation->set_rules('month', 'month', 'required');
			$this->form_validation->set_rules('year', 'year', 'required');
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
// echo "<pre>";
// print_r($osHistory); die();
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
		$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
		$query = $this->jompay->get();
        $condo = $query->result();
		
		//assign cust type
		if($user[0]->GROUPID == '2'){
			$custType = 'O';//owner
		}
		else{
			$custType = 'T';//tenant
		}
		
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 
						  'UserIdNo' => $_SESSION['userid'], 'ReceiptNo' => $ReceiptNo);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/ReceiptRead';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		
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
	
	public function Reminder($page=1)
	{
		//call the model
		$data['company'] = $this->header_model->get_Company();
        $osReminder = $this->outstanding_model->get_os_reminder();
        $data['osReminder'] = array();
        $offset = ($page - 1) * 10;
        $paginatedFiles = array();

        if (count($osReminder) > 0) {
            $paginatedFiles = array_slice($osReminder, $offset, 10, true);
        }
		
		if ($paginatedFiles) {
            foreach ($paginatedFiles as $file) {
                $data['osReminder'][] = array('reminderDate'=>$file['reminderDate'],
											  'reminderNo'=>$file['reminderNo'],
											  'message'=>$file['message'],
											  'outstanding'=>$file['outstanding']);
            }
        }
		
		//pagination
        $config['base_url'] = base_url()."index.php/Common/Outstanding/Reminder";
        $config['total_rows'] = count($osReminder);
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
			$this->load->view('Mgmt/Setup/Outstanding/Reminder',$data);
		}
		else{
			$this->load->view('User/header',$data);
			$this->load->view('User/nav');
			$this->load->view('User/footer');
			$this->load->view('User/Outstanding/Reminder',$data);
		}
	}

	public function GenerateReminder($ReminderNo)
	{
		//get propertyNo
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
        $user = $query->result();
		
		//get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
		$query = $this->jompay->get();
        $condo = $query->result();
		
		//assign cust type
		if($user[0]->GROUPID == '2'){
			$custType = 'O';//owner
		}
		else{
			$custType = 'T';//tenant
		}
		
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 
						  'UserIdNo' => $_SESSION['userid'], 'CustType' => $custType, 'ReminderNo' => $ReminderNo);

		$url = $condo[0]->SERVICESERVER.':8122/ReminderRead';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		
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
			//redirect('index.php/User/Home/Index');
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
}?>
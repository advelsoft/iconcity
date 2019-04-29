<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class outstanding_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	public function get_os_list()
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
		
		$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'], 'CustType' => $custType);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentUnPaidBrowse';
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
				$UserIdNo = $value['UserIdNo'];
				$CustType = $value['CustType'];
			}
			else if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
			else if($key == 'Result'){
				foreach((array)$value as $k => $v)
				{
					$DocNo = $v['DocNo'];
					$TrxnDate = $v['TrxnDate'];
					$DueDate = $v['DueDate'];
					$Description = $v['Description'];
					$Amount = $v['Amount'];
					
					if($Amount > 0){
						$totalGross += $Amount;
					}
					else if($Amount < 0){
						$totalOpen += $Amount;
					}

					$sql1 = "SELECT * FROM OsToPay WHERE DOCNO = '".$DocNo."' AND CONDOSEQ = '".$CondoSeqNo."'";
					$query2 = $this->jompay->query($sql1);
					$result2 = $query2->result();

					$array[] = array('billerCode'=>$CondoSeqNo,
									 'custType'=>$CustType,
									 'docNo'=>$DocNo,
									 'trxnDate'=>$TrxnDate,
									 'desc'=>$Description,
									 'dueDate'=>$DueDate,
									 'amt'=>$Amount,
									 'totalGross'=>$totalGross,
									 'totalOpen'=>$totalOpen);
				}
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('jompay', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect('index.php/User/Home/Index');
		}
		else{
			if(isset($array)){
				return $array;
			}
			else{
				$this->session->set_flashdata('jompay', '<script language=javascript>alert("No Outstanding");</script>');
				return;
			}
		}
	}
	
	public function get_jompay_ref($bundleRef)
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
		
		$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'],
						  'CustType' => $custType, 'BundleReference' => $bundleRef);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundleJompayRead';
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

				$array = array('date'=>$Date,
							   'billerCode'=>$BillerCode,
							   'ref1'=>$Ref1,
							   'amount'=>$Amount,
							   'totalBills'=>$TotalBills,
							   'bundleRef'=>$bundleRef);
			}
		}
		
		if($Status == 'F'){
			$this->session->set_flashdata('jompay', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			//redirect('index.php/Common/Outstanding/Index');	
		}
		else{
			if(isset($array)){
				return $array;
			}
			else{
				return;
			}
		}
	}
	
	public function get_jompay_bank()
	{
		$this->jompay->from('JomBank');
		$query = $this->jompay->get();
        $result = $query->result();
		
		for ($i = 0; $i < count($result); $i++)
        {
			$array[$i] = array('bankName'=>$result[$i]->SHORTBANKNAME,
							   'bankCode'=>$result[$i]->CWBANKCODE,
							   'bankURL'=>$result[$i]->BANKURL,
							   'bankImg'=>$result[$i]->BANKIMAGEFILE);
		}
		return $array;
	}
	
	public function get_os_history()
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
		
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'], 'CustType' => $custType);
// $this->ad($jsonData);
		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundlePaidBrowseV2';
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
				$CustType = $value['CustType'];
			}
			else if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
			else if($key == 'Result'){
				foreach((array)$value as $k => $v)
				{
					$ReceiptNo = $v['ReceiptNo'];
					$Date = $v['Date'];
					$Amount = $v['Amount'];
					$PaymentReference = $v['PaymentReference'];
					$Method = $v['Method'];
					
					$array[] = array('desc'=>$PaymentReference,
									 'amt'=>$Amount,
									 'datepaid'=>$Date,
									 'receiptno'=>$ReceiptNo,
									 'method'=>$Method);
				}
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect('index.php/User/Home/Index');
		}
		else{
			if(isset($array)){
				return $array;
			}
			else{
				$this->session->set_flashdata('history', '<script language=javascript>alert("No Receipt Generated");</script>');
				return;
			}
		}
	}
	
	public function get_stmt_detail()
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
		// echo $this->input->post('DateFrom'); die();
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 
						  'UserIdNo' => $_SESSION['userid'], 'Month' => $this->input->post('month'), 'Year' => $this->input->post('year'), 'CustType' => $custType);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/StatementReadV2';
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
				$CustType = $value['CustType'];
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
			return $FileUrl;
		}
	}
	
	public function get_UserType()
	{
		$userType = array('O'=>'Owner',
						  'T'=>'Tenant',
						  'B'=>'Both');
        return $userType;
	}
	
	public function get_JomBank()
	{
		$this->jompay->from('JomBank');
        $query = $this->jompay->get();
        $result = $query->result();
		
        $jombank = array('0' => 'Select Value');
        for ($i = 0; $i < count($result); $i++)
        {
            $array = array($result[$i]->CWBANKCODE => $result[$i]->SHORTBANKNAME);
			$jombank = $jombank+$array;
		}
        return $jombank;
	}
	
	public function get_BankLog()
	{
		//get user
		$this->cportal->where('UserID',$_SESSION['userid']);
		$this->cportal->from('Users');
		$query = $this->cportal->get();
		$user = $query->result();
		
		//get bank name
		$this->cportal->where('LoginID',$user[0]->LOGINID);
		$this->cportal->from('BankLog');
		$query = $this->cportal->get();
		$bank = $query->result();
		
		//get bank url
		if(count($bank) > 0){
			$this->jompay->where('SHORTBANKNAME',$bank[0]->BankName);
			$this->jompay->from('JomBank');
			$query = $this->jompay->get();
			return $query->result();
		}
		else{
			return $bank;
		}
	}
	
	public function get_bundle_ref($bills)
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
		
		$temp = explode('|', $bills);
		$j = 1;
		for ($i = 0; $i < count($temp)-1; $i++){
			$docNos[$i] = array('DocNo' => $temp[$i]);
		}

		$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'],
						  'CustType' => $custType, 'Bills' => $docNos);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundleAdd';
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
				$BundleReference = $value['BundleReference'];
				$Date = $value['Date'];
				$Amount = $value['Amount'];
				$TotalBills = $value['TotalBills'];

				$array = array('bundleRef'=>$BundleReference,
							   'date'=>$Date,
							   'amount'=>$Amount,
							   'totalBills'=>$TotalBills);
			}
		}
		
		if($Status == 'F'){
			$this->session->set_flashdata('jompay', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			//redirect('index.php/Common/Outstanding/Index');	
		}
		else{
			if(isset($array)){
				return $array;
			}
			else{
				return;
			}
		}
	}
	
	public function get_user_detail()
	{
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $_SESSION['userid']);
		$query = $this->cportal->get();
		$user = $query->result();
		
		//assign cust type
		if($user[0]->GROUPID == '2'){
			$custType = 'O';//owner
		}
		else{
			$custType = 'T';//tenant
		}
			
		$array = array('UnitSeqNo'=>trim($user[0]->UNITSEQ),
					   'CustType'=>$custType,
					   'customer_name'=>trim($user[0]->OWNERNAME),
					   'customer_email'=>trim($user[0]->EMAIL));
		return $array;
	}
	
	public function get_pending_list()
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

		$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'],
						  'CustType' => $custType);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundleBrowse';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		// echo "<pre>";
		// print_r($jsonData); die();
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
				foreach((array)$value as $k => $v)
				{
					$BundleReference = $v['BundleReference'];
					$Date = $v['Date'];
					$Amount = $v['Amount'];
					$TotalBills = $v['TotalBills'];
					$Ref1 = $v['Ref1'];
					$BillerCode = $v['BillerCode'];

					$array[] = array('bundleRef'=>$BundleReference,
								     'date'=>$Date,
								     'amount'=>$Amount,
								     'totalBills'=>$TotalBills,
								     'ref1'=>$Ref1,
								     'billerCode'=>$BillerCode);
				}
			}
		}
		
		if($Status == 'F'){
			$this->session->set_flashdata('jompay', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect('index.php/Common/Outstanding/Index');	
		}
		else{
			if(isset($array)){
				return $array;
			}
			else{
				return;
			}
		}
	}
	
	public function get_bills_list($bundleRef)
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

		$jsonData = array('UserTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'],
						  'CustType' => $custType, 'BundleReference' => $bundleRef);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentBundleRead';
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
				foreach((array)$value as $k => $v)
				{
					$BundleReference = $v['BundleReference'];
					$Date = $v['Date'];
					$Amount = $v['Amount'];
					$TotalBills = $v['TotalBills'];
					$Ref1 = $v['Ref1'];
					$BillerCode = $v['BillerCode'];

					$array[] = array('bundleRef'=>$BundleReference,
								   'date'=>$Date,
								   'amount'=>$Amount,
								   'totalBills'=>$TotalBills,
								   'ref1'=>$Ref1,
								   'billerCode'=>$BillerCode);
				}
			}
		}
		
		if($Status == 'F'){
			$this->session->set_flashdata('jompay', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			//redirect('index.php/Common/Outstanding/Index');	
		}
		else{
			if(isset($array)){
				return $array;
			}
			else{
				return;
			}
		}
	}
	
	public function get_os_reminder()
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
		
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => $_SESSION['condoseq'], 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'], 'CustType' => $custType, 'Type' => 'A');
		
		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/ReminderList';
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
				$CustType = $value['CustType'];
			}
			else if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
			else if($key == 'Result'){
				foreach((array)$value as $k => $v)
				{
					$ReminderDate = $v['ReminderDate'];
					$ReminderNo = $v['ReminderNo'];
					$Message = $v['Message'];
					$Outstanding = $v['Outstanding'];
					
					$array[] = array('reminderDate'=>$ReminderDate,
									 'reminderNo'=>$ReminderNo,
									 'message'=>$Message,
									 'outstanding'=>$Outstanding);
				}
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect('index.php/User/Home/Index');
		}
		else{
			if(isset($array) && count($array) > 0){
				return $array;
			}
			else{
				$this->session->set_flashdata('history', '<script language=javascript>alert("No Reminder Generated.");</script>');
				return;
			}
		}
	}
}?>
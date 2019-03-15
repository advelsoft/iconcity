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
		
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => GLOBAL_CONDOSEQ, 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'], 'CustType' => $custType);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PaymentUnpaidList';
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
					$Ref1 = $v['Ref1'];
					
					if($Amount > 0){
						$totalGross += $Amount;
					}
					else if($Amount < 0){
						$totalOpen += $Amount;
					}

					$sql1 = "SELECT * FROM OsToPay WHERE DOCNO = '".$DocNo."' AND CONDOSEQ = '".$CondoSeqNo."'";
					$query2 = $this->jompay->query($sql1);
					$result2 = $query2->result();

					if(count($result2) > 0){
						$floatAmt = number_format(floatval($result2[0]->FLOATAMOUNTPAID), 2, '.', '');
					}
					else {
						$floatAmt = "";
					}
					
					$array[] = array('billerCode'=>$CondoSeqNo,
									 'custType'=>$CustType,
									 'docNo'=>$DocNo,
									 'trxnDate'=>$TrxnDate,
									 'desc'=>$Description,
									 'dueDate'=>$DueDate,
									 'amt'=>$Amount,
									 'floatAmt'=>$floatAmt,
									 'ref1'=>$Ref1,
									 'totalGross'=>$totalGross,
									 'totalOpen'=>$totalOpen);
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
				$this->session->set_flashdata('jompay', '<script language=javascript>alert("No outstanding.");</script>');
				return;
			}
		}
	}
	
	public function get_jompay_ref($ref1)
	{
		$this->jompay->from('OsToPay');
		$this->jompay->where('REF1', $ref1);
		$query = $this->jompay->get();
        $result = $query->result();
		
		$this->jompay->from('Condo');
		$this->jompay->where('CondoSeq', $result[0]->CONDOSEQ);
		$query1 = $this->jompay->get();
        $result1 = $query1->result();
		
		$totalAmt = '';
		
		for ($i = 0; $i < count($result); $i++)
        {
			$totalAmt += $result[$i]->AMOUNT;
			
		}
		$array = array('BillerCode'=>$result1[0]->BillerCode,
					   'TotalAmt'=>$totalAmt);
		return $array;
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
		
		$jsonData = array('UserTokenNo' => '1YW6BGB688', 'CondoSeqNo' => GLOBAL_CONDOSEQ, 'UnitSeqNo' => trim($user[0]->UNITSEQ), 'UserIdNo' => $_SESSION['userid'], 'CustType' => $custType, 'Type' => 'A');

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/JompayPaidList';
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
				foreach((array)$value as $k => $v)
				{
					$ReceiptNo = $v['ReceiptNo'];
					$Date = $v['Date'];
					$Amount = $v['Amount'];
					$Ref1 = $v['Ref1'];
					
					$array[] = array('desc'=>$Ref1,
									 'amt'=>$Amount,
									 'datepaid'=>$Date,
									 'receiptno'=>$ReceiptNo);
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
				$this->session->set_flashdata('history', '<script language=javascript>alert("No Payment History.");</script>');
				return;
			}
		}
	}
	
	public function get_totalGross()
	{
		//get propertyNo
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
		
		$sql = "SELECT SUM(Amount) AS totalGross FROM OsToPay WHERE Amount > 0 AND PROPERTYNO = '".$user[0]->PROPERTYNO."' AND CONDOSEQ = '".GLOBAL_CONDOSEQ."' AND CUSTTYPE = '".$custType."'";
		$query = $this->jompay->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			$totalGross = $result[0]->totalGross;
		}
		else{
			$totalGross = "";
		}
		return $totalGross;
	}
	
	public function get_totalOpen()
	{
		//get propertyNo
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
		
		$sql = "SELECT SUM(Amount) AS totalOpen FROM OsToPay WHERE Amount < 0 AND PROPERTYNO = '".$user[0]->PROPERTYNO."' AND CONDOSEQ = '".GLOBAL_CONDOSEQ."' AND CUSTTYPE = '".$custType."'";
		$query = $this->jompay->query($sql);
		$result = $query->result();
		
		if(count($result) > 0){
			$totalOpen = $result[0]->totalOpen;
		}
		else{
			$totalOpen = "";
		}
		return $totalOpen;
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
						  'UserIdNo' => $_SESSION['userid'], 'DateTo' => $this->input->post('DateFrom'), 'CustType' => $custType);

		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/StatementRead';
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
}?>
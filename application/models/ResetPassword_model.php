<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class resetpassword_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}
	
	public function get_users_list()
	{	
		if($_SESSION['role'] == 'Mgmt')
		{
			$this->cportal->select('USERID, LOGINID, PROPERTYNO, OWNERNAME, EMAIL');
			$this->cportal->from('Users');
			$this->cportal->order_by('USERID', 'ASC');
			$query = $this->cportal->get();
			$result = $query->result();
			
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$sql = "SELECT MAX(ModifiedDate) AS LastUpdate FROM Users WHERE USERID = '".$result[$i]->USERID."'";
					$query2 = $this->cportal->query($sql);
					$result2 = $query2->result();
					
					$array[$i] = array('userID'=>$result[$i]->USERID,
									   'loginID'=>$result[$i]->LOGINID,
									   'propertyNo'=>$result[$i]->PROPERTYNO,
									   'ownerName'=>$result[$i]->OWNERNAME,
									   'email'=>$result[$i]->EMAIL);
				}
				return $array;
			}
			else{
				return $result;
			}
		}
	}

	public function get_user($propertyNo)
	{	
		if($_SESSION['role'] == 'Mgmt')
		{
			$this->cportal->select('USERID, LOGINID, PROPERTYNO, OWNERNAME, EMAIL');
			$this->cportal->from('Users');
			$this->cportal->where('PROPERTYNO', $propertyNo);
			$this->cportal->order_by('USERID', 'ASC');
			$query = $this->cportal->get();
			$result = $query->result();
			
			if(count($result) > 0){
				for ($i = 0; $i < count($result); $i++)
				{
					$sql = "SELECT MAX(ModifiedDate) AS LastUpdate FROM Users WHERE USERID = '".$result[$i]->USERID."'";
					$query2 = $this->cportal->query($sql);
					$result2 = $query2->result();
					
					$array[$i] = array('userID'=>$result[$i]->USERID,
									   'loginID'=>$result[$i]->LOGINID,
									   'propertyNo'=>$result[$i]->PROPERTYNO,
									   'ownerName'=>$result[$i]->OWNERNAME,
									   'email'=>$result[$i]->EMAIL);
				}
				return $array;
			}
			else{
				return $result;
			}
		}
	}

	public function get_reset_service($UID)
	{
		$this->cportal->select('EMAIL , LOGINID');
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $UID);
		$query = $this->cportal->get();
        $user = $query->result(); 
		
        //get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
		$query = $this->jompay->get();
        $condo = $query->result();
		
		$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'Email' => trim($user[0]->EMAIL), 'UserLoginId' => trim($user[0]->LOGINID));
		
		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PortalForgotPassword';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		
		foreach($body as $key => $value)
		{
			if($key == 'Req'){
				$CondoSeqNo = $value['CondoSeqNo'];
				$UserTokenNo = $value['SuperTokenNo'];
			}
			else if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
			else if($key == 'Result'){
				$array[] = array('loginID'=>$value['LoginID'],
								 'email'=>$value['Email']);
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Email failed to send: "'.$FailedReason.'". Please contact administrator.");</script>');
			redirect('index.php/Common/ResetPassword/Index');
		}
		else{
			return; //redirect('index.php/Common/ResetPassword/ResetPassword');
		}
	}
	
}?>
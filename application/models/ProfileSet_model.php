<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profileset_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
	}

	public function get_change_list()
	{
		if($_SESSION['role'] == 'Mgmt' || $_SESSION['role'] == 'Tech'){
			$this->jompay->from('Users');
			$this->jompay->where('UserID', $_SESSION['userid']);
			$query = $this->jompay->get();
			return $query->result();
		}
		else{
			$this->cportal->from('Users');
			$this->cportal->where('UserID', $_SESSION['userid']);
			$query = $this->cportal->get();
			return $query->result();
		}
	}

	public function get_changepassword_service()
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
		
		$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'Email' => trim($user[0]->EMAIL), 'UserLoginId' => trim($user[0]->LOGINID), 
		'OldPassword' => $this->input->post('OldPw'), 'NewPassword'=> $this->input->post('NewPw'));
		 // echo "<pre>"; print_r($jsonData);
		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PortalChangePassword';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		// echo "<pre>"; print_r($body); die();
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
				$array[] = array('UserLoginId'=>$value['LOGINID'],
								 'Email'=>$value['EMAIL'],
								 'NewPassword'=>$value['pwdHash']);
				
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect('index.php/Common/ProfileSet/Index');
		}
		else{
			return; //redirect('index.php/Common/ProfileSet/ProfileSet');
		}
	}
}?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forgetpassword_model extends CI_Model
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
		if($_SESSION['role'] == 'Mgmt'){
			$this->db->from('Users');
			$this->db->where('UserID', $_SESSION['userid']);
			$query = $this->db->get();
			return $query->result();
		}
		else{
			$this->cportal->from('Users');
			$this->cportal->where('UserID', $_SESSION['userid']);
			$query = $this->cportal->get();
			return $query->result();
		}
	}

	/*-------------------CRM-------------------*/
	public function user_loginDB($username) 
	{
		$this->db->from('Users');
		$this->db->where('LOGINID', $username);
		return $this->db->count_all_results();
	}
	
	public function get_useridDB($username) 
	{
		$this->db->select('USERID');
		$this->db->from('Users');
		$this->db->where('LOGINID', $username);
		return $this->db->get()->row('USERID');
	}
	
	public function get_userDB($userid)
	{
		$this->db->from('Users');
		$this->db->where('USERID', $userid);
		return $this->db->get()->row();		
	}
	
	/*-------------------Cportal-------------------*/
	public function user_loginPortal($username) 
	{
		$this->cportal->from('Users');
		$this->cportal->where('LOGINID', $username);
		return $this->cportal->count_all_results();
	}
	
	public function get_useridPortal($username) 
	{
		$this->cportal->select('USERID');
		$this->cportal->from('Users');
		$this->cportal->where('LOGINID', $username);
		return $this->cportal->get()->row('USERID');
	}
	
	public function get_userPortal($userid)
	{
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $userid);
		return $this->cportal->get()->row();		
	}
	
	public function get_forget_service()
	{
        //get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
		$query = $this->jompay->get();
        $condo = $query->result();
		
		$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'Email' => $this->input->post('Email'), 'UserLoginId' => $this->input->post('LoginID'));
		
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
			return;
		}
		else{
			redirect('index.php/Common/ForgetPassword/ForgetPassword');
		}
	}
	
}?>
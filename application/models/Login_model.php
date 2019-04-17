<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
		$this->cportal = $this->load->database('cportal',TRUE);
		$this->jompay = $this->load->database('jompay',TRUE);
		$this->load->library('PHPRequests');
	}

	public function login($username, $password)
	{
		$this->db->select('USERID, LOGINID, LOGINPASSWORD');
		$this->db->from('Users');
		$this->db->where('LOGINID', $username);
		$this->db->limit(1);

		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	/*-------------------AllPmrsLive-------------------*/
	public function user_loginDB($username, $password, $condoseq) 
	{
		$this->jompay->from('Users');
		$this->jompay->where('LoginID', $username);
		$this->jompay->where('LoginPassword', $password);
		$this->jompay->where('CondoSeq', $condoseq);
		return $this->jompay->count_all_results();
	}
	
	public function get_useridDB($username, $password) 
	{
		$this->jompay->select('UserID');
		$this->jompay->from('Users');
		$this->jompay->where('LoginID', $username);
		$this->jompay->where('LoginPassword', $password);
		return $this->jompay->get()->row('UserID');
	}
	
	public function get_userDB($userid)
	{
		$this->jompay->from('Users');
		$this->jompay->where('UserID', $userid);
		return $this->jompay->get()->row();		
	}
	
	public function get_attempt_countDB($ipadd, $username)
	{
		$this->jompay->from('UserAttempt');
		$this->jompay->where('LoginID', $username);
		$this->jompay->where('IPAddress', $ipadd);
		return $this->jompay->count_all_results();
	}

	/*-------------------Cportal-------------------*/
	public function user_loginPortalOldPW($username, $password) 
	{
		$this->cportal->from('Users');
		$this->cportal->where('LOGINID', $username);
		$this->cportal->where('LOGINPASSWORD', $password);
		return $this->cportal->count_all_results();
	}

	public function user_loginPortalNewPW($username, $password) 
	{
		//get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
		$query = $this->jompay->get();
		$condo = $query->result();

		$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'LoginId' => $username, 
		'LoginPassword' => $password);
		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/apiAuthenUser';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		
		foreach($body as $key => $value)
		{
			if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect(base_url());
		}
		else{
			return $Status;
		}
	}

	public function user_ForgetAccount($email, $unitNo) 
	{
		//get server, port
		$this->jompay->from('Condo');
		$this->jompay->where('CONDOSEQ', $_SESSION['condoseq']);
		$query = $this->jompay->get();
		$condo = $query->result();

		$jsonData = array('SuperTokenNo' => '2YC9OMDXE0', 'CondoSeqNo' => $_SESSION['condoseq'], 'Email' => $email, 
		'UserLoginId' => $unitNo);
		$url = $condo[0]->SERVICESERVER.':'.$condo[0]->SERVICEPORT.'/PortalForgotPassword';
		$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/json');
		$response = Requests::post($url, $headers, json_encode($jsonData));
		$body = json_decode($response->body, true);
		foreach($body as $key => $value)
		{
			if($key == 'Resp'){
				$Status = $value['Status'];
				$FailedReason = $value['FailedReason'];
				$FailedReasonDeveloper = $value['FailedReasonDeveloper'];
			}
		}

		if($Status == 'F'){
			$this->session->set_flashdata('msg', '<script language=javascript>alert("'.$FailedReason.'");</script>');
			redirect(base_url());
		}
		else{
			$this->session->set_flashdata('msg', '<script language=javascript>alert("Email have been sent.");</script>');
			redirect(base_url());
		}
	}
	
	public function check_firstlogin($username)
	{
		$this->cportal->from('Users');
		$this->cportal->where('LOGINID', $username);
		$this->cportal->where('NEWUSER', '1');
		return $this->cportal->count_all_results();
	}
	
	public function get_useridPortal($username, $password) 
	{
		$this->cportal->select('USERID');
		$this->cportal->from('Users');
		$this->cportal->where('LOGINID', $username);
		// $this->cportal->where('LOGINPASSWORD', $password);
		return $this->cportal->get()->row('USERID');
	}
	
	public function get_userPortal($userid)
	{
		$this->cportal->from('Users');
		$this->cportal->where('USERID', $userid);
		return $this->cportal->get()->row();		
	}
	
	public function get_attempt_count($ipadd, $username)
	{
		$this->cportal->from('UserAttempt');
		$this->cportal->where('LoginID', $username);
		$this->cportal->where('IPAddress', $ipadd);
		return $this->cportal->count_all_results();
	}
	
	private function verify_password_hash($password, $hash) 
	{		
		return password_verify($password, $hash);
	}
	
	public function get_Amenities()
	{
		$this->cportal->from('Amenities');
		$query = $this->cportal->get();
		return $query->result();
	}
	
	public function get_News()
	{
		$this->cportal->from('News');
		$this->cportal->where('NewsTypeID', '1');
		$query = $this->cportal->get();
		return $query->result();
	}
	
	public function get_Company()
	{
		$this->cportal->from('Company');
		$query = $this->cportal->get();
		return $query->result();
	}
	
	public function get_Condo($condoseq)
	{
		$this->jompay->from('Condo');
		$this->jompay->where('CondoSeq', $condoseq);
		$query = $this->jompay->get();
		return $query->result();
	}

	public function get_AllUnit()
	{
		$this->cportal->select('PROPERTYNO');
		$this->cportal->from('Users');
		$query = $this->cportal->get();
		return $query->result();
	}

	public function get_condo_data($condolink)
	{
		$this->jompay->select('CONDOSEQ');
		$this->jompay->select('CONDOCODE');
		$this->jompay->select('CondoName');
		$this->jompay->select('CportalSqlOwner');
		$this->jompay->from('Condo');
		$this->jompay->where('CondoLink', $condolink);
		$query = $this->jompay->get();
		$data = $query->row();
		return $data;
	}

	// public function get_Condocode_from_url($condolink)
	// {
	// 	$this->jompay->select('CONDOCODE');
	// 	$this->jompay->from('Condo');
	// 	$this->jompay->where('CondoLink', $condolink);
	// 	$query = $this->jompay->get();
	// 	$data = $query->row();
	// 	return $data->CONDOCODE;
	// }
}?>
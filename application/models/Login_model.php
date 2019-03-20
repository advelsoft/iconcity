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
	public function user_loginPortal($username, $password) 
	{
		$this->cportal->from('Users');
		$this->cportal->where('LOGINID', $username);
		$this->cportal->where('LOGINPASSWORD', $password);
		return $this->cportal->count_all_results();
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

	public function get_Condoseq_from_url($condolink)
	{
		$this->jompay->select('CONDOSEQ');
		$this->jompay->from('Condo');
		$this->jompay->where('CondoLink', $condolink);
		$query = $this->jompay->get();
		$data = $query->row();
		return $data->CONDOSEQ;
	}

	public function get_Condocode_from_url($condolink)
	{
		$this->jompay->select('CONDOCODE');
		$this->jompay->from('Condo');
		$this->jompay->where('CondoLink', $condolink);
		$query = $this->jompay->get();
		$data = $query->row();
		return $data->CONDOCODE;
	}
}?>
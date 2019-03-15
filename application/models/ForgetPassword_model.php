<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forgetpassword_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
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
	
}?>
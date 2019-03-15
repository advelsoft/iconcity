<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profileset_model extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->cportal = $this->load->database('cportal',TRUE);
	}

	public function get_change_list()
	{
		if($_SESSION['role'] == 'Mgmt' || $_SESSION['role'] == 'Tech'){
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
}?>